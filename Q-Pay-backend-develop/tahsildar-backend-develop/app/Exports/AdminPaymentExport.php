<?php

namespace App\Exports;

use App\Definitions\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdminPaymentExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnWidths,
    WithColumnFormatting,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected Collection $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        $this->collection = $this->collection->whereNull('parent_payment_id');
        $flattened = [];
        foreach ($this->collection as $payment){
            $flattened[] = $payment;
            foreach ($payment->children as $child){
                $flattened[] = $child;
            }
        }
        return new Collection( $flattened);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Invoice Number',
            'Merchant',
            'Customer Mobile num',
            'Requested Payment Value',
            'Actual Payment Value',
            'Payment Request Date',
            'Type',
            'Settlement date',
            'Card number',
            'Status',
            "Payment Type",
            'Requested payments',
            'Transaction Date',
            'Transaction Time',
            'Date From',
            'Date To',
            'Merchant Mobile num',
            'Merchant City',
            'Payment Details',
            'Bank Number',
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->user->full_name,
            $row->customer->phone,
            $row->amount,
            $row->actual_payment ??  $row->amount,
            Carbon::createFromFormat('Y-m-d H:i:s',$row->scheduled_date ?? $row->created_at)->setTimezone('Asia/Riyadh')->format('d-M-y'),
            $row->type,
            '-',
            $row->hash_card,
            PaymentStatus::STATUSES_NAME[$row->status],
            $row->payment_type,
            $row->amount,
            Carbon::createFromFormat('Y-m-d H:i:s',$row->created_at)->setTimezone('Asia/Riyadh')->format('d-M-y'),
            Carbon::createFromFormat('Y-m-d H:i:s',$row->created_at)->setTimezone('Asia/Riyadh')->format('g:i A'),
            $row->scheduled_date,
            $row->expiry_date,
            $row->user->phone,
            $row->user->city->name ?? '',
            $row->details,
            $row->user->bank_account_number,
        ];
    }

    public function columnWidths(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle($sheet->calculateWorksheetDimension()) // Apply to the entire sheet
        ->getAlignment()->setHorizontal('center');

        $sheet->getStyle($sheet->calculateWorksheetDimension()) // Apply to the entire sheet
        ->getAlignment()->setVertical('center');
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {

        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {

                // get layout counts (add 1 to rows for heading row)
                $row_count = $this->collection->count() + 1;
                $column_count = 13;

                // set dropdown column
                $drop_column = 'F';

                // set dropdown options
                $options = PaymentStatus::STATUSES_NAME;

                // set dropdown list for first data row
                $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST );
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Status error');
                $validation->setError('Invalid Status');
                $validation->setPromptTitle('Select Status');
                $validation->setPrompt('Please pick a status from the status list.');
                $validation->setFormula1(sprintf('"%s"',implode(',',$options)));

                // clone validation to remaining rows
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                }

                // set columns to autosize
                for ($i = 1; $i <= $column_count; $i++) {
                    $column = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
