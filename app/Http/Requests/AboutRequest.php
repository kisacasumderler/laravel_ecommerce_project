<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
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
            'name' => 'required',
            'text_1' => 'required|max:150',
            'text_1_icon' => 'required',
            'text_1_content' => 'required|max:250',
            'text_2' => 'required|max:150',
            'text_2_icon' => 'required',
            'text_2_content' => 'required|max:250',
            'text_3' => 'required|max:150',
            'text_3_icon' => 'required',
            'text_3_content' => 'required|max:250',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'İsim alanı zorunludur.',
            'text_1.required' => 'Metin 1 alanı zorunludur.',
            'text_1.max' => 'Metin 1 en fazla 150 karakter uzunluğunda olmalıdır.',
            'text_1_icon.required' => 'Metin 1 ikonu alanı zorunludur.',
            'text_1_content.required' => 'Metin 1 içeriği alanı zorunludur.',
            'text_1_content.max' => 'Metin 1 içeriği en fazla 250 karakter uzunluğunda olmalıdır.',
            'text_2.required' => 'Metin 2 alanı zorunludur.',
            'text_2.max' => 'Metin 2 en fazla 150 karakter uzunluğunda olmalıdır.',
            'text_2_icon.required' => 'Metin 2 ikonu alanı zorunludur.',
            'text_2_content.required' => 'Metin 2 içeriği alanı zorunludur.',
            'text_2_content.max' => 'Metin 2 içeriği en fazla 250 karakter uzunluğunda olmalıdır.',
            'text_3.required' => 'Metin 3 alanı zorunludur.',
            'text_3.max' => 'Metin 3 en fazla 150 karakter uzunluğunda olmalıdır.',
            'text_3_icon.required' => 'Metin 3 ikonu alanı zorunludur.',
            'text_3_content.required' => 'Metin 3 içeriği alanı zorunludur.',
            'text_3_content.max' => 'Metin 3 içeriği en fazla 250 karakter uzunluğunda olmalıdır.',
        ];
    }



}
