<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutRequest;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::where('id',1)->first();

        return view('backend.pages.about.index',compact('about'));
    }
    public function update(AboutRequest $request)
    {
        $id = 1;
        $fileName = About::Where('id',$id)->first()->image ?? null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $yol = 'images\about\\';
            $dosyaTamad = resimyukle($image, 900, 600, $yol);
        }

        About::updateOrCreate(['id'=>$id],[
            'name'=>Guvenlik($request->name),
            'image'=>$dosyaTamad ?? $fileName,
            'content'=>htmlspecialchars($request->content),
            'text_1'=>Guvenlik($request->text_1),
            'text_1_icon'=>Guvenlik($request->text_1_icon),
            'text_1_content'=>Guvenlik($request->text_1_content),
            'text_2'=>Guvenlik($request->text_2),
            'text_2_icon'=>Guvenlik($request->text_2_icon),
            'text_2_content'=>Guvenlik($request->text_2_content),
            'text_3'=>Guvenlik($request->text_3),
            'text_3_icon'=>Guvenlik($request->text_3_icon),
            'text_3_content'=>Guvenlik($request->text_3_content),
        ]);
        return back()->withSuccess('Başarıyla Güncellendi!');
    }
}
