<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'to_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'to_id.required' => 'يجب اختيار المستلم',
            'to_id.exists' => 'المستخدم غير موجود',
            'subject.required' => 'الموضوع مطلوب',
            'body.required' => 'نص الرسالة مطلوب',
        ];
    }
}