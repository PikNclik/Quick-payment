<?php

namespace App\Imports;

use App\Definitions\PaymentStatus;
use App\Definitions\PaymentTypeEnums;
use App\Jobs\SendPaymentNotificationToUser;
use App\Jobs\SendSmsToPhone;
use App\Repositories\Eloquent\CustomerRepository;
use App\Services\CustomerService;
use App\Services\PaymentService;
use App\Services\TerminalBankService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Mockery\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PaymentRequestImport implements ToCollection, WithHeadingRow
{
    private PaymentService $service;
    private CustomerService $customerService;
    private TerminalBankService $terminalBankService;

    public function __construct($service, $customerService, $terminalBankService)
    {
        $this->service = $service;
        $this->customerService = $customerService;
        $this->terminalBankService = $terminalBankService;
    }
    var $exception;
    var $data = [];
    /**
     * @param Collection $rows
     * @return void
     * @throws ValidationException
     */
    public function collection(Collection $rows)
    {
        // Remove arrays with all values set to null
        $rows = array_filter($rows->toArray(), function ($item) {
            return !empty(array_filter($item, function ($value) {
                return $value !== null;
            }));
        });

        $rows =  Validator::make($rows, [
            '*.payer_name' => ['required', 'string', 'max:255'],
            '*.payer_mobile_number' => ['required', 'regex:/^9\d{8}$/'],
            '*.amount' => ['required', 'numeric', 'min:1'],
            '*.details' => ['required', 'string', 'max:255'],
            '*.expiry_date' => ['nullable', 'numeric'],
            '*.scheduled_date' => ['nullable', 'numeric'],
            '*.payment_type' => ['in:NORMAL,PARTIAL,FOLLOW-UP'],
            '*.min_part_limit' => ['nullable', 'integer'],
            '*.merchant_reference' => ['nullable']
        ])->validate();

        DB::beginTransaction();
        try {
            $data['type'] = PaymentTypeEnums::PAYMENT;
            $data['user_id'] = Auth::id();
            $data['terminal_bank_id'] = $this->terminalBankService->getElementBy('active', 1)->id;
            $reference_date = strtotime('1900-01-01 00:00:00');
            $time_start = microtime(true);
            foreach ($rows as  $key => $row) {
                $rowNumber = $key + 1;
                $timestamp_scheduled = $reference_date + ($row['scheduled_date'] - 2) * 24 * 60 * 60;
                $row['scheduled_date'] = $row['scheduled_date'] == null ? null :Carbon::instance(Date::excelToDateTimeObject($row['scheduled_date']));
                $timestamp_expiry = $reference_date + ($row['expiry_date'] - 2) * 24 * 60 * 60;
                $row['expiry_date'] = $row['expiry_date'] == null ? null : Carbon::instance(Date::excelToDateTimeObject($row['expiry_date']));
                $carbonExpiry = $row['expiry_date'] == null ? null :   Carbon::createFromTimestamp($timestamp_expiry);
                $carbonScheduled = $row['scheduled_date'] == null ? null :   Carbon::createFromTimestamp($timestamp_scheduled);
                if (!is_null($carbonScheduled) &&  $carbonScheduled->lte(Carbon::now())) {
                    array_push($this->data, ["row" => $rowNumber, "message" => __('payment.scheduled_date_invalid'), "status" => __("errors.error")]);
                    continue;
                }
                if (!is_null($carbonExpiry) &&  $carbonExpiry->lte($row['scheduled_date'] == null ? Carbon::now() :  $carbonScheduled)) {
                    array_push($this->data, ["row" => $rowNumber, "message" => __('payment.expiry_date_invalid'), "status" => __("errors.error")]);
                    continue;
                }
                $payload = $row;
                $this->customerService->extractCustomer($payload);
                $payload['status'] = empty($payload['scheduled_date']) ? PaymentStatus::PENDING : PaymentStatus::SCHEDULED;
                $result = $this->service->store(array_merge($payload, $data));
                $payment = $result->data;
                if ($result->data->status == PaymentStatus::PENDING) {

                    SendSmsToPhone::dispatch($payment->customer->phone, __('payment.payment_link', ['name' => $payment->user->full_name], $payment->user->language) . ' ' . config('app.url') . '/payForm/' . $payment->uuid);
                    SendPaymentNotificationToUser::dispatch($payment->id);
                    $message = __('payment.invoice_sent');
                } else {
                    $message = __('payment.invoice_scheduled');
                }
                array_push($this->data, ["row" => $rowNumber, "message" => $message, "id" => $payment->id, "status" => __("success.success")]);
            }
            DB::commit();
            $time_end = microtime(true);
            $execution_time_sug = ($time_start - $time_end);
            \Log::info(" Total Execution Time FOR importing : " . ($execution_time_sug * 1000) . 'Milliseconds');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            $this->exception = $exception->getMessage();
        }
    }
}
