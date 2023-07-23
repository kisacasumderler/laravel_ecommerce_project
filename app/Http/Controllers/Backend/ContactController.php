<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderByDesc('id')->paginate(10);
        return view('backend.pages.contact.index', compact('contacts'));
    }
    public function edit($id)
    {
        $contact = Contact::where('id', $id)->firstOrfail();
        return view('backend.pages.contact.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'status' => 'required'
            ],
            [
                'status.required' => 'Statü alanı boş bırakılmamalıdır.'
            ]
        );
        $update = $request->status;
        Contact::where('id', $request->id)->update(['status' => $update]);
        return back()->withSuccess('Başarıyla Güncellendi');
    }

    public function destroy(Request $request)
    {

        $contact = Contact::where('id', $request->id)->firstOrfail();
        dosyasil($contact->image);
        dosyasil($contact->MobileImage);

        $contact->delete();
        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    public function statusUpdate(Request $request)
    {
        $update = $request->statu;
        $updateCheck = $update == 'false' ? '0' : '1';
        Contact::where('id', $request->id)->update(['status' => $updateCheck]);
        return response(['error' => false, 'status' => $updateCheck]);
    }
}
