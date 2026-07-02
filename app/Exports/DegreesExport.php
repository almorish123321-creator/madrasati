<?php

namespace App\Exports;

use App\Models\Degree;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DegreesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $classroomId;

    public function __construct($classroomId)
    {
        $this->classroomId = $classroomId;
    }

    public function collection()
    {
        $studentIds = \App\Models\Student::where('Classroom_id', $this->classroomId)->pluck('id');
        return Degree::whereIn('student_id', $studentIds)->with(['student', 'quizze'])->get();
    }

    public function headings(): array
    {
        return ['المعرف', 'الطالب', 'الاختبار', 'المادة', 'الدرجة'];
    }

    public function map($degree): array
    {
        return [
            $degree->id,
            $degree->student ? $degree->student->getTranslation('name', 'ar') : '',
            $degree->quizze ? $degree->quizze->getTranslation('name', 'ar') : '',
            $degree->quizze && $degree->quizze->subject ? $degree->quizze->subject->getTranslation('name', 'ar') : '',
            $degree->degree,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true, 'size' => 12]]];
    }

    public function title(): string
    {
        return 'كشوف الدرجات';
    }
}