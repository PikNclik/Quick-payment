<?php

namespace App\Services\Admin;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Definitions\CommissionTypes;
use App\Definitions\PaymentTypeEnums;
use App\Exports\TransactionToDoALBarakaExternalExport;
use App\Exports\TransactionToDoALBarakaInternalExport;
use App\Models\Bank;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Eloquent\SystemBankDataRepository;
use App\Repositories\Eloquent\TransactionToDoRepository;
use App\Services\BaseService;
use App\Services\WorkingDayHolidayService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class TransactionToDoService extends BaseService
{

    protected string $modelName = 'Translation-To-Do';
    /**
     * BankService constructor.
     * @param TransactionToDoRepository $repository
     * @param PaymentRepository $paymentRepository
     * @param SystemBankDataRepository $systemBankDataRepository
     */
    public function __construct(
        TransactionToDoRepository        $repository,
        private PaymentRepository        $paymentRepository,
        private SystemBankDataRepository $systemBankDataRepository
    ) {
        parent::__construct($repository);
    }

    public function createToDoForPayment($payment_id): void
    {
        $payment = $this->paymentRepository->findById($payment_id, ['*'], ['user', 'customer', 'terminal_bank', 'terminal_bank.internal_commission', 'terminal_bank.external_commission']);

        // get user bank id
        if ($payment->type == PaymentTypeEnums::PAYMENT)
            $relation = 'user';
        else if ($payment->type == PaymentTypeEnums::TRANSFER)
            $relation = 'customer';
        $mechant_bank_id = $payment->{$relation}->bank_id;
        $merchant_bank_account_number = $payment->{$relation}->bank_account_number;

        // get terminal_bank id and check if has any default system bank in same bank
        $terminal_bank_id = $payment->terminal_bank->bank_id;
        $terminal_bank_account_number = $payment->terminal_bank->bank_account_number;
        $dueDate = resolve(WorkingDayHolidayService::class)->getNextSettlementDate();
        if ($terminal_bank_id == $mechant_bank_id)
            $commissionScheme = $payment->terminal_bank->internal_commission;
        else
            $commissionScheme = $payment->terminal_bank->external_commission;
        if ($commissionScheme != null) {
            $actualCommission =  $commissionScheme->commission_fixed + (($commissionScheme->commission_percentage * $payment->actual_payment)/100);
            if ($actualCommission < $commissionScheme->min)
                $actualCommission = $commissionScheme->min;
            else if ($actualCommission > $commissionScheme->max)
                $actualCommission = $commissionScheme->max;

            $amountAfterCommission =  $payment->actual_payment - $actualCommission;

        }

        if (!$commissionScheme || $commissionScheme->type == CommissionTypes::IGNORE) {
            $transaction_to_do =
                // from Qpay terminal to merchant account
                [
                    'payment_id' => $payment->id,
                    'amount' => $payment->actual_payment,
                    'from_bank_account_number' => $terminal_bank_account_number,
                    'from_bank_id' => $terminal_bank_id,
                    'to_bank_account_number' => $merchant_bank_account_number,
                    'to_bank_id' => $mechant_bank_id,
                    'due_date' => $dueDate,
                    'type'=> 'payment',
                ];
            $this->repository->create($transaction_to_do);
        } else {
            DB::beginTransaction();
            try {

                if ($commissionScheme->type == CommissionTypes::DIRECT) {

                    $first_transaction_to_do =
                    // from Qpay terminal to merchant account
                    [
                        'payment_id' => $payment->id,
                        'amount' => $amountAfterCommission,
                        'from_bank_account_number' => $terminal_bank_account_number,
                        'from_bank_id' => $terminal_bank_id,
                        'to_bank_account_number' => $merchant_bank_account_number,
                        'to_bank_id' => $mechant_bank_id,
                        'due_date' => $dueDate,
                        'type'=> 'payment',
                    ];
                    $second_transaction_to_do =
                        // from Qpay terminal to commission account
                        [
                            'payment_id' => $payment->id,
                            'amount' => $actualCommission,
                            'from_bank_account_number' => $terminal_bank_account_number,
                            'from_bank_id' => $terminal_bank_id,
                            'to_bank_account_number' => $commissionScheme->bank_account_number,
                            'to_bank_id' => $terminal_bank_id,
                            'due_date' => $dueDate,
                            'type'=> 'direct',
                        ];
                } else {
                    $first_transaction_to_do =
                    // from Qpay terminal to merchant account
                    [
                        'payment_id' => $payment->id,
                        'amount' => $payment->actual_payment,
                        'from_bank_account_number' => $terminal_bank_account_number,
                        'from_bank_id' => $terminal_bank_id,
                        'to_bank_account_number' => $merchant_bank_account_number,
                        'to_bank_id' => $mechant_bank_id,
                        'due_date' => $dueDate,
                        'type'=> 'payment',
                    ];
                    $second_transaction_to_do =
                        // from merchant account to commission account
                        [
                            'payment_id' => $payment->id,
                            'amount' => $actualCommission,
                            'from_bank_account_number' => $merchant_bank_account_number,
                            'from_bank_id' => $mechant_bank_id,
                            'to_bank_account_number' => $commissionScheme->bank_account_number,
                            'to_bank_id' => $terminal_bank_id,
                            'due_date' => $dueDate,
                            'type'=> 'indirect',
                        ];

                }
                $this->repository->create($first_transaction_to_do);
                $this->repository->create($second_transaction_to_do);
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
                Log::error($exception->getMessage());
            }
        }
    }


    public function export(
        $exportClass,
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
        $result = $this->repository->getTransactionToDoList($length, $filters, $relations, $sortKeys, $sortDir, false);
        return Excel::download(new $exportClass($result), $this->modelName . '.xlsx');
    }

    /**
     * @param $import_class
     * @param $file
     * @return ApiSharedMessage
     */
    public function import($import_class, $file): ApiSharedMessage
    {
        $import_class = resolve($import_class);
        $result = Excel::import(new $import_class(), $file);

        return new ApiSharedMessage(
            __('success.import', ['model' => $this->modelName]),
            $result,
            true,
            null,
            200
        );
    }

    public function getTransactionToDoList($perPage, $filters = [], $with = [], $sortKeys = ['id'], $sortDir = ['asc']): ApiSharedMessage
    {


        return new ApiSharedMessage(
            __('success.import', ['model' => $this->modelName]),
            $this->repository->getTransactionToDoList($perPage, $filters, $with, $sortKeys, $sortDir),
            true,
            null,
            200
        );
    }

    public function exportAlbarakaTransactions()
    {

        $files = [];
        $bankExcelsFile = $this->addPaymentTransactionBasedOnBanks();
        array_push($files,...$bankExcelsFile);
        $commissionExcelFile = $this->addCommissionExcelFile ();
        array_push($files,$commissionExcelFile);
        $zipFileName = 'exports.zip';
        $zipPath = storage_path('app/' . $zipFileName);

        // Create Excel files and add them to the zip
        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
            foreach ($files as  $export) {
                $fileName = $export["name"];
                $filePath = storage_path("app/{$fileName}");
                Excel::store($export['file'], $fileName);
                $zip->addFile($filePath, $fileName);
            }
            $zip->close();
        }
        return response()->download($zipPath)->deleteFileAfterSend(true);


    }

   private function addPaymentTransactionBasedOnBanks ()
    {
        $files = [];
        $data = collect($this->repository->getALBarakaToDoTransactionsWithoutComission());
        foreach ($data as $key => $fromBank  ){
            $fromBankName =Bank::find($key)->name;
            foreach ($fromBank as $toKey => $toBank){
                $toBankName =Bank::find($toKey)->name;
                if ($key == 21 && $toKey == 21){
                    $excel =new  TransactionToDoALBarakaInternalExport($toBank);
                } else {
                    $excel =new  TransactionToDoALBarakaExternalExport($toBank);
                }
                $fileName = "${fromBankName} - ${toBankName}.xlsx";
                array_push($files,[
                    "name"=>$fileName,
                    "file"=> $excel
                ]);
            }
        }
        return $files;
    }

    private function addCommissionExcelFile ()
    {
        $data = collect($this->repository->getALBarakaToDoCommission());
        $excel = new  TransactionToDoALBarakaInternalExport($data);
        return [
            "name"=>"Commission File.xlsx",
            "file"=> $excel
        ];
    }
}
