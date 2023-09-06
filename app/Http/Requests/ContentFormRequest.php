<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentFormRequest extends FormRequest
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
            'name' => 'required|string|min:5',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required|max:500',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'İsim Soyisim boş bırakılmamalıdır.',
            'name.string' => 'İsim Soyisim uygun formatta olmalıdır.',
            'name.min' => 'İsim Soyisim uygun formatta olmalıdır.',
            'email.required' => 'E posta alanı boş bırakılmamalıdır.',
            'email.email' => 'E posta alanı uygun formatta olmalıdır.',
            'subject.required' => 'Konu alanı boş bıraklımamalıdır.',
            'message.required' => 'Mesaj alanı boş bıraklımamalıdır.',
            'message.max'=>'Mesaj en fazla 500 karakter uzunluğunda olmalıdır.'
        ];
    }


}
