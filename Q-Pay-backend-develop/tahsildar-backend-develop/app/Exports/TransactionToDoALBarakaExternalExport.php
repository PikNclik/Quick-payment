<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
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
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class TransactionToDoALBarakaExternalExport implements
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
    public function __construct(Collection $collection,)
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
            'تاريخ الملف',
            'Sender AC.',
            'Beneficiary AC.',
            'Beneficiary Name',
            'Sender Bank',
            'Beneficiary Bank',
            'Amount',
            'Bank Trx. No'
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
//        dd(collect($row));
        $row->from_bank_id = $row->real_from_bank_id;
       return [
           now()->format('d/m/Y'),
           $row->from_bank_account_number,
           $row->to_bank_account_number,
           $row->payment->user->full_name,
           $row->from_bank->name,
           $row->to_bank->name,
           $row->amount,
           "-",
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

    }

    public function registerEvents(): array
    {
        return [];
    }
}
