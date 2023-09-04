<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Coupon;
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


        $newProducts = Product::where('status', '1')->where('qty', '>', '0')->orderByDesc('id')->with('images')->limit(10)->get();

        $couponsWithProducts =
            Product::where('status', '1')->where('qty', '>', '0')
                ->orderBy('price', 'ASC')
                ->with('images')
                ->whereHas('couponsWithProducts')
                ->with('couponsWithProducts')
                ->limit(10)
                ->get();

        $about = About::where('id', '1')->first();

        $specialOffer = specialOffer::where('status', '1')->orderByDesc('id')->first();

        // indirim
        $discounts = Coupon::where('status', '1')->where('isDiscount', '1')->where('qty', '>', '0')->get();

        $seoLists = metaolustur('anasayfa');

        $seo = [
            'title' => $seoLists['title'] ?? config('app.name') . ' | Anasayfa',
            'description' => $seoLists['description'] ?? config('app.name') . ' | Açıklama',
            'keywords' => $seoLists['keywords'] ?? config('app.name') . ', alışveriş, eticaret, kadın, erkek, çocuk,aksesuar, anasayfa',
            'image' => asset('img/page-bg.jpg'),
            'url' => $seoLists['currenturl'] ?? null,
            'canonical' => $seoLists['trpage'] ?? null,
            'robots' => 'index,follow',
        ];


        return view('frontend.pages.index', compact('seo', 'sliders', 'slidersMobile', 'home', 'about', 'newProducts', 'specialOffer', 'discounts', 'couponsWithProducts'));
    }
}
