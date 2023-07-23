<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'c_country' => 'required|string',
            'c_name' => 'required|string|min:3',
            'c_companyname' => 'nullable|string',
            'c_city' => 'required|string',
            'c_address' => 'required|string',
            'c_state_country' => 'required|string',
            'c_postal_zip' => 'required|numeric',
            'c_email_address' => 'required|email',
            'c_phone' => 'required|numeric',
            'order_note' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'c_country.required' => 'Müşteri Ülkesi alanı zorunludur.',
            'c_country.string' => 'Müşteri Ülkesi alanı metin formatında olmalıdır.',
            'c_name.required' => 'Müşteri Adı alanı zorunludur.',
            'c_name.string' => 'Müşteri Adı alanı metin formatında olmalıdır.',
            'c_name.min' => 'Müşteri Adı en az :min karakter uzunluğunda olmalıdır.',
            'c_companyname.string' => 'Müşteri Şirket Adı alanı metin formatında olmalıdır.',
            'c_city.required' => 'Müşteri Şehir alanı zorunludur.',
            'c_city.string' => 'Müşteri Şehir alanı metin formatında olmalıdır.',
            'c_address.required' => 'Müşteri Adresi alanı zorunludur.',
            'c_address.string' => 'Müşteri Adresi alanı metin formatında olmalıdır.',
            'c_state_country.required' => 'Müşteri Eyalet/Ülke alanı zorunludur.',
            'c_state_country.string' => 'Müşteri Eyalet/Ülke alanı metin formatında olmalıdır.',
            'c_postal_zip.required' => 'Müşteri Posta Kodu/ZİP alanı zorunludur.',
            'c_postal_zip.numeric' => 'Müşteri Posta Kodu/ZİP alanı sadece numerik değerlerden oluşmalıdır.',
            'c_email_address.required' => 'Müşteri E-posta Adresi alanı zorunludur.',
            'c_email_address.email' => 'Geçerli bir e-posta adresi giriniz.',
            'c_phone.required' => 'Müşteri Telefon alanı zorunludur.',
            'c_phone.numeric' => 'Müşteri Telefon alanı sadece numerik değerlerden oluşmalıdır.',
            'order_note.string' => 'Sipariş notu alanı metin formatında olmalıdır.',
        ];
    }
}
