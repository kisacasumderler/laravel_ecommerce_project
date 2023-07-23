<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;



class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('backend.pages.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.slider.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $yol = 'images\slider\\';
            $dosyaTamad = resimyukle($image,1600,600,$yol);
        }

        if ($request->hasFile('MobileImage')) {
            $MobileResim = $request->file('MobileImage');
            $yol = 'images\slider\\';
            $MobileDosyaAd = resimyukle($MobileResim,1000,1000,$yol);
        }

        Slider::create(
            [
                'image' => $dosyaTamad ?? null,
                'MobileImage' => $MobileDosyaAd ?? null,
                'name' => Guvenlik($request->name),
                'content' => Guvenlik($request->content),
                'link' => Guvenlik($request->link),
                'status' => Guvenlik($request->status),
            ]
        );

        return back()->withSuccess('Başarıyla Oluşturuldu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::where('id', $id)->first();
        return view('backend.pages.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $query = Slider::where('id', $request->id);
        $slider = $query->firstOrfail();
        $fileName = $query->first()->image ?? null;
        $mobileFileName = $query->first()->MobileImage ?? null;

        if ($request->hasFile('image')) {
            dosyasil($slider->image);
            $image = $request->file('image');
            $yol = 'images\slider\\';
            $dosyaTamad = resimyukle($image,1600,600,$yol);
        }

        if ($request->hasFile('MobileImage')) {
            dosyasil($slider->MobileImage);
            $MobileResim = $request->file('MobileImage');
            $yol = 'images\slider\\';
            $MobileDosyaAd = resimyukle($MobileResim,1000,1000,$yol);
        }

        Slider::where('id', $id)->update(
            [
                'image' => $dosyaTamad ?? $fileName,
                'MobileImage' => $MobileDosyaAd ?? $mobileFileName,
                'name' => Guvenlik($request->name),
                'content' => Guvenlik($request->content),
                'link' => Guvenlik($request->link),
                'status' => Guvenlik($request->status),
            ]
        );

        return back()->withSuccess('Başarıyla Güncellendi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $slider = Slider::where('id', $request->id)->firstOrfail();
        dosyasil($slider->image);
        dosyasil($slider->MobileImage);

        $slider->delete();
        return response(['error'=>false, 'message'=>'Başarıyla Silindi.']);
    }

    public function statusUpdate(Request $request) {
        $update = $request->statu;
        $updateCheck = $update == 'false' ? '0' : '1';
        Slider::where('id',$request->id)->update(['status'=>$updateCheck]);
        return response(['error'=>false,'status'=>$updateCheck]);
    }
}
