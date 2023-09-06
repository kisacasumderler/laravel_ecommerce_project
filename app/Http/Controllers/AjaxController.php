<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentFormRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function iletisimkaydet(ContentFormRequest $request)
    {

        $newData = [
            'name' => Guvenlik($request->name),
            'email' => Guvenlik($request->email),
            'subject' => Guvenlik($request->subject),
            'message' => Guvenlik($request->message),
            'ip' => $request->ip(),
        ];

        $sonkaydedilen = Contact::create($newData);

        if($sonkaydedilen) {
            return response()->json(['message'=>'Başarıyla Gönderildi','error'=>false]);
        }else {
            return response()->json(['message'=>'İletişim Kaydetme işleminde hata alınmaktadır.','error'=>true]);
        }


    }

    public function logout () {
        Auth::logout();
        return redirect()->route('anasayfa');
    }
}
