<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class AttendanceImport implements ToCollection, WithHeadingRow
{
    protected $errors;

    public function __construct()
    {
        $this->errors = collect();
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNum = $index + 2;
            $studentId = $row['student_id'] ?? null;
            $date = $row['date'] ?? null;
            $status = $row['status'] ?? null;

            if (empty($studentId)) {
                $this->errors->push(['row' => $rowNum, 'field' => 'student_id', 'message' => 'رقم الطالب مطلوب']);
                continue;
            }
            if (empty($date)) {
                $this->errors->push(['row' => $rowNum, 'field' => 'date', 'message' => 'التاريخ مطلوب']);
                continue;
            }
            if ($status === null || $status === '') {
                $this->errors->push(['row' => $rowNum, 'field' => 'status', 'message' => 'حالة الحضور مطلوبة (0=حاضر, 1=غائب)']);
                continue;
            }

            $student = Student::where('id', $studentId)->first();
            if (!$student) {
                $this->errors->push(['row' => $rowNum, 'field' => 'student_id', 'message' => 'الطالب غير موجود: ' . $studentId]);
                continue;
            }

            $normalizedStatus = 0;
            if (in_array($status, [1, '1', 'غائب', 'absent'])) {
                $normalizedStatus = 1;
            }

            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'attendence_date' => $date],
                [
                    'grade_id' => $student->Grade_id,
                    'classroom_id' => $student->Classroom_id,
                    'section_id' => $student->section_id,
                    'teacher_id' => 1,
                    'attendence_status' => $normalizedStatus,
                ]
            );
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}