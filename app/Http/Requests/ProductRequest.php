<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:100',
            'content' => 'required|max:500',
            'status' => 'required',
            'kdv' => 'sometimes|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ürün adı girilmesi zorunludur',
            'name.max' => 'ürün adı max 100 karakter olmalıdır.',
            'content.required' => 'Ürün içerik bilgisi girilmesi zorunludur',
            'content.max' => 'İçerik max 500 karakter olmalıdır.',
            'status.required' => 'Durum seçimi yapılmalıdır.',
            'kdv.required' => 'KDV alanı zorunludur.',
            'kdv.numeric' => 'KDV alanı sadece sayısal bir değer olmalıdır.',
        ];
    }
}
