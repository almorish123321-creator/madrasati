<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBehavioralRecordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:positive,negative',
            'description' => 'required|string|max:500',
            'points' => 'required|integer|min:0',
            'date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'يجب اختيار الطالب',
            'type.required' => 'يجب اختيار النوع',
            'type.in' => 'النوع يجب أن يكون إيجابي أو سلبي',
            'description.required' => 'الوصف مطلوب',
            'points.required' => 'النقاط مطلوبة',
            'date.required' => 'التاريخ مطلوب',
        ];
    }
}