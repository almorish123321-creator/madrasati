<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeacherImportTemplateExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    public function headings(): array
    {
        return [
            'name_ar', 'name_en', 'email', 'phone', 'date_birth',
            'gender_name', 'specialization_name', 'nationalitie_name', 'blood_name',
            'joining_date', 'address',
        ];
    }

    public function array(): array
    {
        return [[
            'علي محمد', 'Ali Mohammed', 'ali@example.com', '0501234567', '1985-05-20',
            'ذكر', 'رياضيات', 'سعودي', 'O+', '2020-09-01', 'الرياض',
        ]];
    }

    public function title(): string
    {
        return 'نموذج استيراد المعلمين';
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true, 'size' => 12]]];
    }
}