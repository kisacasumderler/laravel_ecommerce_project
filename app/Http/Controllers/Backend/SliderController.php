<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\ImageMedia;
use App\Models\Slider;
use App\Models\SliderMobile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;



class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::with('images')->get();
        return view('backend.pages.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('backend.pages.slider.edit');
    }

    public function store(SliderRequest $request)
    {

        $sliderArray = [];
        $sliderArray['name'] = Guvenlik($request->name);
        $sliderArray['content'] = Guvenlik($request->content);
        $sliderArray['link'] = Guvenlik($request->link);
        $sliderArray['status'] = Guvenlik($request->status);

        $slider = Slider::create($sliderArray);

        $sliderMobile = SliderMobile::create($sliderArray);


        if ($request->hasFile('image')) {
            $this->fileSave('Slider', 'slider', $request, $slider);
        }

        if ($request->hasFile('MobileImage')) {
            $this->fileSave('SliderMobile', 'sliderMobile', $request, $sliderMobile,'MobileImage');
        }

        return back()->withSuccess('Başarıyla Oluşturuldu');
    }

    public function edit($id)
    {
        $slider = Slider::where('id', $id)->with('images')->first();
        $sliderMobile = SliderMobile::where('id',$id)->with('images')->first();
        return view('backend.pages.slider.edit', compact('slider','sliderMobile'));
    }

    public function update(Request $request, $id)
    {
        $query = Slider::where('id', $request->id);
        $slider = $query->firstOrfail();
        $sliderMobile = SliderMobile::where('id',$request->id)->firstOrCreate();


        $sliderArray = [];
        $sliderArray['name'] = Guvenlik($request->name);
        $sliderArray['content'] = Guvenlik($request->content);
        $sliderArray['link'] = Guvenlik($request->link);
        $sliderArray['status'] = Guvenlik($request->status);

        $slider->update($sliderArray);

        $sliderMobile->update($sliderArray);

        if ($request->hasFile('image')) {
            $this->fileSave('Slider', 'slider', $request, $slider);
        }
        if ($request->hasFile('MobileImage')) {
            $this->fileSave('SliderMobile', 'slider', $request, $sliderMobile,'MobileImage');
        }

        return back()->withSuccess('Başarıyla Güncellendi');
    }

    public function destroy(Request $request)
    {

        $slider = Slider::where('id', $request->id)->firstOrfail();

        $imageMedia = ImageMedia::where('model_name', 'Slider')->where('table_id', $slider->id)->first();

        if (!empty($imageMedia->data)) {
            foreach ($imageMedia->data as $img) {
                dosyasil($img['image']);
            }
            $imageMedia->delete();
        }

        $slider->delete();
        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    public function statusUpdate(Request $request)
    {
        $update = $request->statu;
        $updateCheck = $update == 'false' ? '0' : '1';
        Slider::where('id', $request->id)->update(['status' => $updateCheck]);
        return response(['error' => false, 'status' => $updateCheck]);
    }
}
