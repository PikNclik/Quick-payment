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

class TransactionToDoALBarakaInternalExport implements
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
            "TRX_TYPE",
            "TRS_AC_BR",
            "TRS_AC_CY",
            "TRS_AC_GL",
            "TRS_AC_CIF",
            "TRS_AC_SL",
            "TRS_CY",
            "AMOUNT",
            "INSTRUCTIONS1",
            "INSTRUCTIONS2",
            "INSTRUCTIONS3",
            "INSTRUCTIONS4",
            "TO_TRS_AC_BR",
            "TO_TRS_AC_CY",
            "TO_TRS_AC_GL",
            "TO_TRS_AC_CIF",
            "TO_TRS_AC_SL",
            "BENEF_BANK/REQUESTED_BY",
            "BENEF_BANK_BR",
            "BENEF_BANK_ADDRESS",
            "BENEF_NAME",
            "BENEF_ACC",
            "BENEF_ADDRESS",
            "BENEF_ADDRESS_2",
            "BENEF_ADDRESS_3",
            "STATUS_REASON_DESC",
            "APPROVE_BY",
            "WAIVE_CHARGES"
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        $row->from_bank_id = $row->real_from_bank_id;
        $fromBranch = substr( $row->from_bank_account_number,0,3);
        $fromGl = substr( $row->from_bank_account_number,3,3);
        $fromCif =  substr( $row->from_bank_account_number,6,7);
        $fromCy =  substr( $row->from_bank_account_number,13,3);
        $fromSl = substr( $row->from_bank_account_number,16,3);

        $toBranch = substr( $row->to_bank_account_number,0,3);
        $toGl = substr( $row->to_bank_account_number,3,3);
        $toCif =  substr( $row->to_bank_account_number,6,7);
        $toCy =  substr( $row->to_bank_account_number,13,3);
        $toSl = substr( $row->to_bank_account_number,16,3);
        return [
            150,
            $fromBranch,
            $fromCy,
            $fromGl,
            $fromCif,
            $fromSl,
            $fromCy,
            $row->amount,
            "",
            "",
            "",
            "",
            $toBranch,
            $toCy,
            $toGl,
            $toCif,
            $toSl,
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            ""
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
        return [
        ];
    }
}
