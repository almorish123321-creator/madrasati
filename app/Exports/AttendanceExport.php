<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromView, WithTitle, WithStyles
{
    protected $classroomId;
    protected $month;
    protected $year;

    public function __construct($classroomId, $month, $year)
    {
        $this->classroomId = $classroomId;
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * عرض البيانات من Blade view لملف Excel
     */
    public function view(): View
    {
        $classroom = Classroom::findOrFail($this->classroomId);

        // جلب الطلاب في هذا الصف
        $students = Student::where('Classroom_id', $this->classroomId)
            ->with(['gender', 'section'])
            ->orderBy('seat_number')
            ->orderBy('id')
            ->get();

        // جلب سجلات الحضور لهذا الشهر
        $attendances = Attendance::where('classroom_id', $this->classroomId)
            ->whereMonth('attendence_date', $this->month)
            ->whereYear('attendence_date', $this->year)
            ->get()
            ->groupBy('student_id');

        // عدد أيام الشهر
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);

        // أسماء الأشهر بالعربية
        $monthNames = [
            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
            5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
            9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
        ];

        $monthName = $monthNames[$this->month] ?? '';

        return view('pages.Exports.attendance_excel', compact(
            'classroom', 'students', 'attendances', 'daysInMonth', 'monthName', 'month', 'year'
        ));
    }

    public function title(): string
    {
        $classroom = Classroom::find($this->classroomId);
        return 'الحضور والغياب - ' . ($classroom ? $classroom->Name_Class : '');
    }

    /**
     * تنسيق ملف Excel
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->setRightToLeft(true);

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            3 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4472C4']],
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            ],
        ];
    }
}