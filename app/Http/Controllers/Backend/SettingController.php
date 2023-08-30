<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $sets = SiteSetting::get();
        return view('backend.pages.setting.index', compact('sets'));

    }
    public function create()
    {
        return view('backend.pages.setting.edit');
    }

    public function store(Request $request)
    {
        $key = $request->name;

        //

        if ($request->hasFile('image')) {
            dosyasil($request->data);
            $image = $request->file('image');
            $yol = 'images\setting\\';
            $dosyaTamad = resimyukle($image, 500, 500, $yol);
        }

        //


        SiteSetting::firstOrCreate([
            'name' => $key,
            'data' => $dosyaTamad ?? $request->data,
            'set_type' => $request->set_type
        ]);

        return back()->withSuccess('Başarılı');
    }
    public function edit($id)
    {
        $setting = SiteSetting::where('id', $id)->first();
        return view('backend.pages.setting.edit', compact('setting'));
    }
    public function update(Request $request, $id)
    {
        $setting = SiteSetting::where('id', $id)->first();

        $key = $request->name;


        //

        if ($request->hasFile('image')) {
            dosyasil($setting->data);
            $image = $request->file('image');
            $yol = 'images\setting\\';
            $dosyaTamad = resimyukle($image, 500, 500, $yol);
        }

        //

        $setting->update([
            'name' => $key,
            'data' => $dosyaTamad ?? $request->data,
            'set_type' => $request->set_type
        ]);

        return back()->withSuccess('Başarıyla Güncellendi');
    }

    public function destroy(Request $request)
    {

        $siteSetting = SiteSetting::where('id', $request->id)->firstOrfail();
        dosyasil($siteSetting->data);

        $siteSetting->delete();
        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }
}
