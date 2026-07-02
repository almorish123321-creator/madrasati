<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\Gender;
use App\Models\Nationalitie;
use App\Models\Specialization;
use App\Models\Type_Blood;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class TeachersImport implements ToCollection, WithHeadingRow
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
                $this->errors->push(['row' => $rowNum, 'field' => 'name', 'message' => 'اسم المعلم مطلوب']);
                continue;
            }

            if (empty($email)) {
                $this->errors->push(['row' => $rowNum, 'field' => 'email', 'message' => 'البريد الإلكتروني مطلوب']);
                continue;
            }

            if (Teacher::where('email', $email)->exists()) {
                $this->errors->push(['row' => $rowNum, 'field' => 'email', 'message' => 'البريد موجود مسبقا: ' . $email]);
                continue;
            }

            $gender = Gender::where('id', $row['gender_id'] ?? null)->first();
            if (!$gender && !empty($row['gender_name'])) {
                $gender = Gender::where('name', 'LIKE', '%' . $row['gender_name'] . '%')->first();
            }

            $specialization = Specialization::where('id', $row['specialization_id'] ?? null)->first();
            if (!$specialization && !empty($row['specialization_name'])) {
                $specialization = Specialization::where('Name', 'LIKE', '%' . $row['specialization_name'] . '%')->first();
            }

            $nationalitie = Nationalitie::where('id', $row['nationalitie_id'] ?? null)->first();
            if (!$nationalitie && !empty($row['nationalitie_name'])) {
                $nationalitie = Nationalitie::where('Name', 'LIKE', '%' . $row['nationalitie_name'] . '%')->first();
            }

            $blood = Type_Blood::where('id', $row['blood_id'] ?? null)->first();
            if (!$blood && !empty($row['blood_name'])) {
                $blood = Type_Blood::where('name', 'LIKE', '%' . $row['blood_name'] . '%')->first();
            }

            Teacher::create([
                'name' => ['ar' => $nameAr ?? '', 'en' => $nameEn ?? ($nameAr ?? '')],
                'email' => $email,
                'password' => Hash::make('12345678'),
                'Gender_id' => $gender ? $gender->id : null,
                'Specialization_id' => $specialization ? $specialization->id : null,
                'nationalitie_id' => $nationalitie ? $nationalitie->id : null,
                'blood_id' => $blood ? $blood->id : null,
                'Date_Birth' => $row['date_birth'] ?? null,
                'Joining_Date' => $row['joining_date'] ?? now()->toDateString(),
                'Address' => $row['address'] ?? null,
                'phone' => $row['phone'] ?? null,
            ]);
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}