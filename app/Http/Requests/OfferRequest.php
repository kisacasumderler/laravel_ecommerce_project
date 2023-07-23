<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'name' => 'required|max:50|min:3',
            'message' => 'required|max:150|min:3',
            'title'=>'required|min:3',
        ];

    }

    public function messages()
    {
        return [
            'name.required'=>'Kampanya adı girilmesi zorunludur',
            'name.max' => 'Kampanya max 100 karakter olmalıdır.',
            'name.min' => 'Kampanya min 3 karakter olmalıdır.',
            'message.required'=>'Kampanya içerik bilgisi girilmesi zorunludur',
            'message.max' => 'Kampanya max 500 karakter olmalıdır.',
            'message.min' => 'Kampanya min 3 karakter olmalıdır.',
            'status.required'=>'Durum seçimi yapılmalıdır.'
        ];
    }
}
