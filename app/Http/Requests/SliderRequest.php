<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'max:100',
            'content' => 'max:150',
            'status'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.max' => 'Başlık max 100 karakter olmalıdır.',
            'content.max' => 'İçerik max 150 karakter olmalıdır.',
            'status.required'=>'Durum seçimi yapılmalıdır.'
        ];
    }
}
