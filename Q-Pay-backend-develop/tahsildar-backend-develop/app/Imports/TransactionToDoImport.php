<?php

namespace App\Imports;

use App\Definitions\PaymentStatus;
use App\Models\Payment;
use App\Models\TransactionToDo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Mockery\Exception;

class TransactionToDoImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     * @return void
     * @throws ValidationException
     */
    public function collection(Collection $rows): void
    {
        Validator::make($rows->toArray(), [
            '*.id'=>[],
            '*.payment_id' => ['required', Rule::exists('transaction_to_dos', 'payment_id')],
            '*.executed' => ['required', Rule::in(['yes', 'no'])],
        ])->validate();
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $executed = $row['executed'] == 'yes';
                TransactionToDo::where('payment_id',$row['payment_id'])->update(['executed' => $executed]);
                if ($executed){
                    Payment::where('id',$row['payment_id'])->update(['status'=> PaymentStatus::SETTLED]);
                }
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        }

    }
}
