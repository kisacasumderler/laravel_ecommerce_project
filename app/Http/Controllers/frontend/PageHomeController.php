<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\SliderMobile;
use App\Models\specialOffer;
use DB;
use Illuminate\Http\Request;


class PageHomeController extends Controller
{
    public function anasayfa()
    {
        $sliders = Slider::where('status', '1')->with('images')->get();
        $slidersMobile = SliderMobile::where('status', '1')->with('images')->get();
        $home = 'Anasayfa';

        $newProducts = Product::where('status', '1')->orderByDesc('id')->limit(10)->get();

        $about = About::where('id', '1')->first();

        $specialOffer = specialOffer::where('status', '1')->orderByDesc('id')->first();

        $seoLists = metaolustur('anasayfa');

        $seo = [
            'title' => $seoLists['title'] ?? null,
            'description' => $seoLists['description'] ?? null,
            'keywords' => $seoLists['keywords'] ?? null,
            'image' => asset('img/page-bg.jpg') ?? null,
            'url' => $seoLists['currenturl'] ?? null,
            'canonical' => $seoLists['trpage'] ?? null,
            'robots' => 'index,follow',
        ];


        return view('frontend.pages.index', compact('seo', 'sliders', 'slidersMobile', 'home', 'about', 'newProducts', 'specialOffer'));
    }
}
