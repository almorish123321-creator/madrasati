<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'driver' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'route' => 'nullable|string|max:500',
            'capacity' => 'nullable|integer|min:1|max:100',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الحافلة مطلوب',
            'capacity.min' => 'السعة يجب أن تكون 1 على الأقل',
        ];
    }
}