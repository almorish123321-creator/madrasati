<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentImportTemplateExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    public function headings(): array
    {
        return [
            'name_ar', 'name_en', 'email', 'date_birth', 'gender_name',
            'nationalitie_name', 'blood_name', 'grade_name', 'classroom_name',
            'section_name', 'parent_email', 'academic_year',
        ];
    }

    public function array(): array
    {
        return [[
            'محمد أحمد', 'Mohammed Ahmed', 'mohammed@example.com', '2010-01-15',
            'ذكر', 'سعودي', 'A+', 'المرحلة الاولى', 'الفصل أ', 'القسم ١', 'parent@example.com', '2026',
        ]];
    }

    public function title(): string
    {
        return 'نموذج استيراد الطلاب';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
