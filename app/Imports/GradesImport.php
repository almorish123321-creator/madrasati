<?php

namespace App\Imports;

use App\Models\Degree;
use App\Models\Student;
use App\Models\Quizze;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class GradesImport implements ToCollection, WithHeadingRow
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
            $quizzeId = $row['quizze_id'] ?? null;
            $degree = $row['degree'] ?? null;

            if (empty($studentId)) {
                $this->errors->push(['row' => $rowNum, 'field' => 'student_id', 'message' => 'رقم الطالب مطلوب']);
                continue;
            }

            if (empty($quizzeId)) {
                $this->errors->push(['row' => $rowNum, 'field' => 'quizze_id', 'message' => 'رقم الاختبار مطلوب']);
                continue;
            }

            if ($degree === null || $degree === '') {
                $this->errors->push(['row' => $rowNum, 'field' => 'degree', 'message' => 'الدرجة مطلوبة']);
                continue;
            }

            if (!Student::where('id', $studentId)->exists()) {
                $this->errors->push(['row' => $rowNum, 'field' => 'student_id', 'message' => 'الطالب غير موجود: ' . $studentId]);
                continue;
            }

            if (!Quizze::where('id', $quizzeId)->exists()) {
                $this->errors->push(['row' => $rowNum, 'field' => 'quizze_id', 'message' => 'الاختبار غير موجود: ' . $quizzeId]);
                continue;
            }

            if ($degree > 100 || $degree < 0) {
                $this->errors->push(['row' => $rowNum, 'field' => 'degree', 'message' => 'الدرجة غير صالحة: ' . $degree]);
                continue;
            }

            Degree::updateOrCreate(
                ['student_id' => $studentId, 'quizze_id' => $quizzeId],
                ['degree' => $degree, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}