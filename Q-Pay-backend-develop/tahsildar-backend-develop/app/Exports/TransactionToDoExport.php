<?php

namespace App\Exports;

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

class TransactionToDoExport implements
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
        return $this->collection;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Qpay ID',
            'Payment ID',
            'From Account',
            'From Bank',
            'To Account',
            'To Bank',
            'Amount',
            'Executed'
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
           (string)$row->id,
           $row->payment_id,
           $row->from_bank_account_number,
           $row->from_bank->name,
           $row->to_bank_account_number,
           $row->to_bank->name,
           $row->amount,
           $row->executed ? "yes" : "no",
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
                $column_count = 6;

                // set dropdown column
                $drop_column = 'H';

                // set dropdown options
                $options = ['yes','no'];

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
