<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsListExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function collection()
    {
        return Student::with(['grade', 'classroom', 'section', 'gender', 'Nationality', 'myparent'])->get();
    }

    public function headings(): array
    {
        return [
            'المعرف', 'الاسم (عربي)', 'الاسم (انجليزي)', 'البريد', 'تاريخ الميلاد',
            'المرحلة', 'الفصل', 'القسم', 'الجنس', 'الجنسية', 'ولي الأمر', 'رقم هاتف ولي الأمر',
        ];
    }

    public function map($student): array
    {
        return [
            $student->id,
            $student->getTranslation('name', 'ar'),
            $student->getTranslation('name', 'en'),
            $student->email,
            $student->Date_Birth,
            $student->grade ? $student->grade->getTranslation('Name_Grade', 'ar') : '',
            $student->classroom ? $student->classroom->Name_Class : '',
            $student->section ? $student->section->getTranslation('Name_Section', 'ar') : '',
            $student->gender ? $student->gender->getTranslation('name', 'ar') : '',
            $student->Nationality ? $student->Nationality->getTranslation('Name', 'ar') : '',
            $student->myparent ? $student->myparent->getTranslation('father_name', 'ar') : '',
            $student->myparent ? $student->myparent->father_phone : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function title(): string
    {
        return 'قائمة الطلاب';
    }
}