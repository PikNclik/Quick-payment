<?php

namespace App\Exports;

use App\Definitions\PaymentStatus;
use App\Models\TransactionToDo;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class PaymentExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder  implements
    FromCollection,
    WithCustomValueBinder,
    WithHeadings,
    WithMapping,
    WithColumnWidths,
    WithColumnFormatting,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected Collection $collection;
    protected array $unwantedColumns;


    public function __construct(Collection $collection,$unwantedColumns)
    {
        $this->collection = $collection;
        $this->unwantedColumns = $unwantedColumns ?? [];
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
        $headings = [
            __('payment_export.invoice_number'),
            __('payment_export.customer_name'),
            __('payment_export.customer_mobile'),
            __('payment_export.requested_payment_value'),
            __('payment_export.actual_payment_value'),
            __('payment_export.payment_request_date'),
            __('payment_export.paid_datetime'),
            __('payment_export.rrn'),
            __('payment_export.settlement_date'),
            __('payment_export.status'),
            __('payment_export.payment_type'),
            __('payment_export.create_datetime'),
            __('payment_export.payment_details'),
            __('payment_export.receiving_bank_name'),
            __('payment_export.bank_number'),
        ];
        foreach ($this->unwantedColumns as $column ){
            unset($headings[$column]);
        }
        return  $headings;
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        $transactionToDo = TransactionToDo::where("payment_id",$row->id)->first();
        $data = [
           $row->id,
           $row->customer->name,
           $row->customer->phone,
            number_format($row->amount),
            number_format($row->actual_payment ??  $row->amount,),
           Carbon::createFromFormat('Y-m-d H:i:s',$row->scheduled_date ?? $row->created_at)
               ->setTimezone('Asia/Riyadh')->format('d-M-y'),
           !$transactionToDo ? '' : Carbon::parseFromLocale($transactionToDo->created_at)
               ->setTimezone('Asia/Riyadh')->format('d-M-y g:i:s A'),
           $row->rrn,
           '-',
           __('payment_export.'.PaymentStatus::STATUSES_NAME[$row->status]),
           __('payment_export.'.$row->payment_type),
           Carbon::createFromFormat('Y-m-d H:i:s',$row->created_at)
               ->setTimezone('Asia/Riyadh')->format('d-M-y g:i:s A'),
           $row->details,
           $row->user->bank->name,
           $row->user->bank_account_number,
       ];
        foreach ($this->unwantedColumns as $column ){
            unset($data[$column]);
        }
        return $data;
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
//            "C" => NumberFormat::FORMAT_TEXT,
//            "D" => NumberFormat::FORMAT_TEXT,
//            "E" => NumberFormat::FORMAT_TEXT,
//            "H" => NumberFormat::FORMAT_TEXT,
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
                $event->sheet->getDelegate()->setRightToLeft(app()->getLocale() === 'ar');

                // get layout counts (add 1 to rows for heading row)
                $row_count = $this->collection->count() + 1;
                $column_count = 13;

                // set dropdown column
                $drop_column = $this->getColumnIndex(__('payment_export.status'),$event->sheet);

                // set dropdown options
                $options = PaymentStatus::STATUSES_NAME;
                $translatedOptions = [];
                foreach ( $options as $option){
                    if ($option != 'Refunded')
                    array_push($translatedOptions, __('payment_export.'.$option),);
                }

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
                $validation->setFormula1(sprintf('"%s"',implode(',',$translatedOptions)));

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
    function  getColumnIndex ($column,$sheet){
        $headerRow = 1;
        // Loop through columns in the header row
        $highestColumn = $sheet->getHighestColumn(); // Get the highest column in the sheet
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn); // Convert it to index

        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            // Convert column index to letter (A, B, C, ...)
            $columnLetter = Coordinate::stringFromColumnIndex($col);

            // Get the value of the cell in the header row
            $cellValue = $sheet->getCell($columnLetter . $headerRow)->getValue();

            // Check if it matches the desired header
            if ($cellValue === $column) {
                // This is the matching column
                return $columnLetter;
            }
        }
    }
}
