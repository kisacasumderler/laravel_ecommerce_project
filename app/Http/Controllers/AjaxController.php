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
        return back()->with(['message'=>'Başarıyla Gönderildi']);
    }

    public function logout () {
        Auth::logout();
        return redirect()->route('anasayfa');
    }
}
