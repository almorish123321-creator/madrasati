<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GradesImportTemplateExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    public function headings(): array
    {
        return ['student_id', 'quizze_id', 'degree'];
    }

    public function array(): array
    {
        return [[1, 1, 85]];
    }

    public function title(): string
    {
        return 'نموذج استيراد الدرجات';
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true, 'size' => 12]]];
    }
}