<?php

namespace App\Exports;

use App\Exports\Traits\ExcelStylesTrait;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GenericArrayExport implements FromArray, WithHeadings, WithStyles
{
    use ExcelStylesTrait;
    protected $headings;
    protected $data;

    public function __construct($headings, $data)
    {
        $this->headings = $headings;
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
