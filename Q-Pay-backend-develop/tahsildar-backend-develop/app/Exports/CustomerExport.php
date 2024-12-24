<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnWidths,
    WithColumnFormatting,
    ShouldAutoSize,
    WithStyles
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
            'ID',
            'Name',
            'Phone',
            'Customer Bank Account Number',
            'Customer Bank',
            'Created At',
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
           $row->name,
           $row->phone,
           $row->bank_account_number,
           $row->bank?->name,
           Carbon::createFromFormat('Y-m-d H:i:s',$row->created_at)->setTimezone('Asia/Riyadh')->format('Y-m-d'),
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

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
