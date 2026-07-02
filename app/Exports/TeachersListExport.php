<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeachersListExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function collection()
    {
        return Teacher::with(['specializations', 'genders', 'Sections'])->get();
    }

    public function headings(): array
    {
        return [
            'المعرف', 'الاسم (عربي)', 'الاسم (انجليزي)', 'البريد', 'الهاتف',
            'التخصص', 'الجنس', 'تاريخ الميلاد', 'العنوان', 'الأقسام',
        ];
    }

    public function map($teacher): array
    {
        $sections = $teacher->Sections->pluck('Name_Section')->implode('، ');
        return [
            $teacher->id,
            $teacher->getTranslation('name', 'ar'),
            $teacher->getTranslation('name', 'en'),
            $teacher->email,
            $teacher->phone ?? '',
            $teacher->specializations ? $teacher->specializations->getTranslation('Name', 'ar') : '',
            $teacher->genders ? $teacher->genders->getTranslation('name', 'ar') : '',
            $teacher->Date_Birth,
            $teacher->Address ?? '',
            $sections,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true, 'size' => 12]]];
    }

    public function title(): string
    {
        return 'قائمة المعلمين';
    }
}