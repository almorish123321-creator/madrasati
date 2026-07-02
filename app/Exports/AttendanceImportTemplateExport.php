<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceImportTemplateExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    public function headings(): array
    {
        return ['student_id', 'date', 'status'];
    }

    public function array(): array
    {
        return [
            [1, '2026-06-28', 0],
            [2, '2026-06-28', 1],
        ];
    }

    public function title(): string
    {
        return 'نموذج استيراد الحضور';
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true, 'size' => 12]]];
    }
}