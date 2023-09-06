<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Models\Category;
use App\Models\specialOffer;
use Illuminate\Http\Request;

class SpecialOfferController extends Controller
{
    public function index()
    {
        $offer = specialOffer::where('id',1)->first();

        $categories = Category::where('status', '1')->select('id','name','cat_ust')->get();
        $categories = groupCategory($categories);

        return view('backend.pages.specialOffer.index',compact('offer','categories'));
    }
    public function update(OfferRequest $request)
    {
        // return $request->all();

        $id = 1;
        $fileName = specialOffer::Where('id',$id)->first()->image ?? null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $yol = 'images\offer\\';
            $dosyaTamad = resimyukle($image, 900, 600, $yol);
        }

        specialOffer::updateOrCreate(['id'=>$id],[
            'name'=>$request->name,
            'image'=>$dosyaTamad ?? $fileName,
            'title'=>$request->title,
            'message'=>$request->message,
            'link'=>'indirimdekiurunler'
        ]);
        return back()->withSuccess('Başarıyla Güncellendi!');
    }

    public function statusUpdate(Request $request) {
        $update = $request->statu;
        $updateCheck = $update == 'false' ? '0' : '1';
        specialOffer::where('id',$request->id)->update(['status'=>$updateCheck]);
        return response(['error'=>false,'status'=>$updateCheck]);
    }
}
