<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Gender;
use App\Models\Nationalitie;
use App\Models\Type_Blood;
use App\Models\Grade;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\My_Parent;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class StudentsImport implements ToCollection, WithHeadingRow
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
            $nameAr = $row['name_ar'] ?? null;
            $nameEn = $row['name_en'] ?? null;
            $email = $row['email'] ?? null;

            if (empty($nameAr) && empty($nameEn)) {
                $this->errors->push(['row' => $rowNum, 'field' => 'name', 'message' => 'اسم الطالب مطلوب']);
                continue;
            }

            if (empty($email)) {
                $this->errors->push(['row' => $rowNum, 'field' => 'email', 'message' => 'البريد الإلكتروني مطلوب']);
                continue;
            }

            if (Student::where('email', $email)->exists()) {
                $this->errors->push(['row' => $rowNum, 'field' => 'email', 'message' => 'البريد موجود مسبقا: ' . $email]);
                continue;
            }

            $gender = Gender::where('id', $row['gender_id'] ?? null)->first();
            if (!$gender && !empty($row['gender_name'])) {
                $gender = Gender::where('name', 'LIKE', '%' . $row['gender_name'] . '%')->first();
            }

            $grade = Grade::where('id', $row['grade_id'] ?? null)->first();
            if (!$grade) {
                $gradeName = $row['grade_name'] ?? null;
                if ($gradeName) {
                    $grade = Grade::where('Name_Grade', 'LIKE', '%' . $gradeName . '%')->first();
                }
                if (!$grade) {
                    $this->errors->push(['row' => $rowNum, 'field' => 'grade', 'message' => 'المرحلة غير موجودة: ' . ($row['grade_name'] ?? $row['grade_id'] ?? '')]);
                    continue;
                }
            }

            $classroom = Classroom::where('id', $row['classroom_id'] ?? null)->first();
            if (!$classroom && !empty($row['classroom_name'])) {
                $classroom = Classroom::where('Name_Class', 'LIKE', '%' . $row['classroom_name'] . '%')
                    ->where('Grade_id', $grade->id)->first();
            }

            $section = Section::where('id', $row['section_id'] ?? null)->first();
            if (!$section && !empty($row['section_name']) && $classroom) {
                $section = Section::where('Name_Section', 'LIKE', '%' . $row['section_name'] . '%')
                    ->where('Class_id', $classroom->id)->first();
            }

            $nationalitie = Nationalitie::where('id', $row['nationalitie_id'] ?? null)->first();
            if (!$nationalitie && !empty($row['nationalitie_name'])) {
                $nationalitie = Nationalitie::where('Name', 'LIKE', '%' . $row['nationalitie_name'] . '%')->first();
            }

            $blood = Type_Blood::where('id', $row['blood_id'] ?? null)->first();
            if (!$blood && !empty($row['blood_name'])) {
                $blood = Type_Blood::where('name', 'LIKE', '%' . $row['blood_name'] . '%')->first();
            }

            $parent = My_Parent::where('id', $row['parent_id'] ?? null)->first();
            if (!$parent && !empty($row['parent_email'])) {
                $parent = My_Parent::where('email', $row['parent_email'])->first();
            }

            Student::create([
                'name' => ['ar' => $nameAr ?? '', 'en' => $nameEn ?? ($nameAr ?? '')],
                'email' => $email,
                'password' => Hash::make('12345678'),
                'gender_id' => $gender ? $gender->id : null,
                'nationalitie_id' => $nationalitie ? $nationalitie->id : null,
                'blood_id' => $blood ? $blood->id : null,
                'Date_Birth' => $row['date_birth'] ?? null,
                'Grade_id' => $grade->id,
                'Classroom_id' => $classroom ? $classroom->id : null,
                'section_id' => $section ? $section->id : null,
                'parent_id' => $parent ? $parent->id : null,
                'academic_year' => $row['academic_year'] ?? date('Y'),
            ]);
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}