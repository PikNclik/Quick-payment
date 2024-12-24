<?php

namespace App\Services;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Definitions\PaymentStatus;
use App\Definitions\PaymentTypeEnums;
use App\Jobs\SendPaymentNotificationToUser;
use App\Jobs\SendSmsToPhone;
use App\Repositories\Eloquent\PaymentRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use TCPDF;

class PaymentService extends BaseService
{


    /**
     * PaymentService constructor.
     * @param PaymentRepository $repository
     */
    public function __construct(PaymentRepository $repository, private TerminalBankService $terminalBankService, private CustomerService $customerService)
    {
        parent::__construct($repository);
    }

    public function getSumAmount($user_id, $data): ApiSharedMessage
    {
        $data['paid'] = $this->repository->getSumAmountByStatus($user_id, $data, PaymentStatus::PAID);
        $data['pending'] = $this->repository->getSumAmountByStatus($user_id, $data, PaymentStatus::PENDING);
        return new ApiSharedMessage(
            __('success.all', ['model' => $this->modelName]),
            $data,
            true,
            null,
            200
        );
    }

    public function export(
        $exportClass,
        array  $unwantedColumns = [],
        array  $columns = [],
        array  $relations = [],
        int    $length = 10,
        array  $sortKeys = ['id'],
        array  $sortDir = ['asc'],
        array  $filters = [],
        array  $searchableFields = [],
        string $search = null,
        bool   $searchInRelation = false,
        int    $withTrash = 0,
        array  $joinsArray = [],
        bool   $isPaginate = true
    ): BinaryFileResponse {
        $result = $this->repository->all($columns, $relations, $length, $sortKeys, $sortDir, $filters, $searchableFields, $search, $searchInRelation, $withTrash, $joinsArray, $isPaginate);
        return Excel::download(new $exportClass($result,$unwantedColumns), $this->modelName . '.xlsx');
    }

    public function exportPdf(int $id)
    {
        $payment = $this->repository->findById($id);
        if ($payment) {
            $status=PaymentStatus::STATUSES_NAME[$payment->status];
            $paymentRequestDate=Carbon::createFromFormat('Y-m-d H:i:s',$payment->scheduled_date ?? $payment->created_at)->setTimezone('Asia/Riyadh')->format('Y-m-d h:i');
            $transactionDate= Carbon::createFromFormat('Y-m-d H:i:s',$payment->created_at)->setTimezone('Asia/Riyadh')->format('Y-m-d h:i');
            $from= $payment->scheduled_date?Carbon::createFromFormat('Y-m-d H:i:s',$payment->scheduled_date)->setTimezone('Asia/Riyadh')->format('Y-m-d h:i'):'';
            $to= $payment->expiry_date?Carbon::createFromFormat('Y-m-d H:i:s',$payment->expiry_date)->setTimezone('Asia/Riyadh')->format('Y-m-d h:i'):'';
            $html = View::make('export/payment', ['payment' => $payment,'status' => $status,'paymentRequestDate'=>$paymentRequestDate,'transactionDate'=>$transactionDate,'from'=>$from,'to'=>$to,'img_url' =>  public_path('logo.jpg')])->render();

            // Create a new TCPDF object
            $pdf = new TCPDF();

            // Set document information (optional)
            // $pdf->SetCreator(PDF_CREATOR);
            // $pdf->SetAuthor('Your Name');
            // $pdf->SetTitle('PDF Title');
            // $pdf->SetSubject('PDF Subject');

            // Set margins
            $pdf->SetMargins(15, 20, 15);
            // $pdf->SetHeaderMargin(10);
            // $pdf->SetFooterMargin(10);

            // Set auto page breaks
            $pdf->SetAutoPageBreak(true, 15);

            // Set font
            // $pdf->SetFont('dejavusans', '', 12);

            // Add a page
            $pdf->AddPage();
            if (App::getLocale()=='ar')
                $pdf->setRTL(true);
            else
                $pdf->setRTL(false);
            // Set HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            // Output the PDF as a download
            return response($pdf->Output('document.pdf', 'S'), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="document.pdf"');
        }
    }

    public function cancel(int $id): ApiSharedMessage
    {
        $payment = $this->repository->findById($id);
        if (!$payment) {
            return new ApiSharedMessage(
                __('errors.not_found', ['model' => "Resource"]),
                null,
                false,
                null,
                404
            );
        }
        $status = null;

        if (in_array($payment->status, PaymentStatus::CAN_CANCELED_STATUSES)) {
            $status = PaymentStatus::CANCELLED;
        }
        if ($status) {
            return new ApiSharedMessage(
                __('success.cancel', ['model' => "Resource"]),
                $this->repository->update($id, ['status' => $status]),
                true,
                null,
                200
            );
        } else {
            return new ApiSharedMessage(
                __('errors.not_allowed', ['model' => "Resource",'status'=>__('payment_export.'.PaymentStatus::STATUSES_NAME[$payment->status])]),
                null,
                false,
                null,
                404
            );
        }
    }

    public function getByUuid(string $uuid)
    {
        return $this->repository->getElementBy('uuid', $uuid);
    }

    /**
     * @param $import_class
     * @param $file
     * @return ApiSharedMessage
     */
    public function import($import_class, $file): ApiSharedMessage
    {
        $data = [];
        $exception = null;
        if (!is_string($import_class)) {
            $result = Excel::import($import_class, $file);
            // these variables currently exists on PaymentRequestImport only
            //        $result->data,
            //        $result->exception,
            $data =  $import_class->data;
            $exception =  $import_class->exception;
        } else {
            $import_class = resolve($import_class);
            $result = Excel::import(new $import_class(), $file);
        }


        return new ApiSharedMessage(
            __('success.import', ['model' => "Payment"]),
            $data,
            true,
            $exception,
            200
        );
    }


    public function storeBulkJson($inputData): ApiSharedMessage
    {
        DB::beginTransaction();
        try {
            $dataToSave = [];
            $dataToSave['type'] = PaymentTypeEnums::PAYMENT;
            $dataToSave['user_id'] = Auth::id();
            $dataToSave['terminal_bank_id'] = $this->terminalBankService->getElementBy('active', 1)->id;
            $time_start = microtime(true);
            $res = [];
            $dataToSave['scheduled_date'] = isset($inputData['scheduled_date']) ? $inputData['scheduled_date'] : null;
            $dataToSave['expiry_date'] = isset($inputData['expiry_date']) ? $inputData['expiry_date'] : null;
            $dataToSave['amount'] =  $inputData['amount'];
            $dataToSave['details'] = isset($inputData['details']) ? $inputData['details'] : null;
            if (isset($inputData['payment_type'])) {
                $dataToSave['payment_type'] =  $inputData['payment_type'];
            }

            $dataToSave['min_part_limit'] = isset($inputData['min_part_limit']) ? $inputData['min_part_limit'] : null;
            foreach ($inputData['payers'] as $row) {

                $payload = $row;
                $this->customerService->extractCustomer($payload);
                $payload['status'] = empty($payload['scheduled_date']) ? PaymentStatus::PENDING : PaymentStatus::SCHEDULED;
                $result = $this->store(array_merge($payload, $dataToSave));
                $payment = $result->data;
                if ($result->data->status == PaymentStatus::PENDING) {

                    SendSmsToPhone::dispatch($payment->customer->phone, __('payment.payment_link', ['name' => $payment->user->full_name], $payment->user->language) . ' ' . config('app.url') . '/payForm/' . $payment->uuid);
                    SendPaymentNotificationToUser::dispatch($payment->id);
                    $message = 'invoice sent successfully';
                } else {
                    $message = 'invoice is scheduled';
                }
                array_push($res, ["payer_name" => $row['payer_name'], "payer_mobile_number" => $row['payer_mobile_number'], "id" => $payment->id]);
            }
            DB::commit();
            $time_end = microtime(true);
            $execution_time_sug = ($time_start - $time_end);
            Log::info(" Total Execution Time FOR storeBulkJson : " . ($execution_time_sug * 1000) . 'Milliseconds');
            return new ApiSharedMessage(
                $message,
                $res,
                true,
                null,
                200
            );
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        }
    }

    public function getStatistics($data): ApiSharedMessage
    {
        return new ApiSharedMessage(
            __('success.index', ['model' => "Payment"]),
            $this->repository->getStatics($data),
            true,
            null,
            200
        );
    }

    public function getMerchantPaymentsAsCustomer($data): ApiSharedMessage
    {
        return new ApiSharedMessage(
            __('success.index', ['model' => "Payment"]),
            $this->repository->getMerchantPaymentsAsCustomer($data),
            true,
            null,
            200
        );
    }

    public function createFromPartPayment($partPayment)
    {
        $newPaymentPayload = [
            'amount' => $partPayment->amount - $partPayment->actual_payment,
            'details' => $partPayment->details,
            'merchant_reference' => $partPayment->merchant_reference,
            'min_part_limit' => $partPayment->min_part_limit,
            'payment_type' => $partPayment->payment_type,
            'type' => $partPayment->type,
            'status' => PaymentStatus::PENDING,
            'expiry_date' => $partPayment->expiry_date,
            'scheduled_date' => $partPayment->scheduled_date,
            'fees_percentage' => $partPayment->fees_percentage,
            'customer_id' => $partPayment->customer_id,
            'terminal_bank_id' => $partPayment->terminal_bank_id,
            'user_id' => $partPayment->user_id,
            'parent_payment_id' => $partPayment->parent_payment_id ?? $partPayment->id
        ];
        $newPayment = $this->repository->create($newPaymentPayload);
        $result = $this->view($newPayment->id, ['*'], ['user', 'customer']);
        $payment = $result->data;
        SendSmsToPhone::dispatch($payment->customer->phone, __('payment.payment_link', ['name' => $payment->user->full_name], $payment->user->language) . ' ' . config('app.url') . '/payForm/' . $payment->uuid);
        SendPaymentNotificationToUser::dispatch($payment->id);
        return $payment;
    }
}
