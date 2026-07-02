<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeworkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:Grades,id',
            'section_id' => 'required|exists:sections,id',
            'deadline' => 'required|date|after:today',
            'file' => 'nullable|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,png,jpeg|max:10240',
        ];

        if ($this->method() !== 'PUT') {
            $rules['title'] = 'required|array';
            $rules['title.ar'] = 'required|string|max:255';
            $rules['title.en'] = 'required|string|max:255';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'عنوان الواجب مطلوب',
            'subject_id.required' => 'يجب اختيار المادة',
            'section_id.required' => 'يجب اختيار القسم',
            'deadline.required' => 'تاريخ التسليم مطلوب',
            'deadline.after' => 'تاريخ التسليم يجب أن يكون بعد اليوم',
        ];
    }
}