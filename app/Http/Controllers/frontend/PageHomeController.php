<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\specialOffer;
use DB;
use Illuminate\Http\Request;


class PageHomeController extends Controller
{
    public function anasayfa()
    {
        $sliders = Slider::where('status', '1')->get();
        $home = 'Anasayfa';

        $newProducts = Product::where('status','1')->orderByDesc('id')->limit(10)->get();

        $about = About::where('id','1')->first();

        $specialOffer = specialOffer::where('status','1')->orderByDesc('id')->first();

        return view('frontend.pages.index', compact('sliders','home','about','newProducts','specialOffer'));
    }
}
