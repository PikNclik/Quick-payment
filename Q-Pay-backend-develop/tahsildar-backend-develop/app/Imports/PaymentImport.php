<?php

namespace App\Imports;

use App\Definitions\PaymentStatus;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Mockery\Exception;

class PaymentImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     * @return void
     * @throws ValidationException
     */
    public function collection(Collection $rows): void
    {
        Validator::make($rows->toArray(), [
            '*.invoice_number' => ['required', Rule::exists('payments', 'id')],
            '*.status' => ['required', Rule::in(PaymentStatus::STATUSES_NAME)],
        ])->validate();
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $status = array_search($row['status'],PaymentStatus::STATUSES_NAME);
                Payment::query()->where('id',$row['invoice_number'])->update(['status' => $status]);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        }

    }
}
