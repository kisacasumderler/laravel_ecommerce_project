<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function hakkimizda()
    {
        $about = About::where('id', '1')->with('images')->first();
        $Breadcrumb = [
            'sayfalar' => [],
            'active' => 'Hakkımızda'
        ];

        $seoLists = metaolustur('hakkimizda');

        $seo = [
            'title' => $seoLists['title'] ?? config('app.name') . ' Kimdir?',
            'description' => $seoLists['description'] ?? config('app.name') . ' Hakkında Bilgi',
            'keywords' => $seoLists['keywords'] ?? config('app.name') . ', hakkında, kimdir',
            'image' => asset('img/page-bg.jpg'),
            'url' => $seoLists['currenturl'] ?? null,
            'canonical' => $seoLists['trpage'] ?? null,
            'robots' => 'index,follow',
        ];

        return view('frontend.pages.about', compact('seo', 'about', 'Breadcrumb'));
    }
    public function urundetay($slug)
    {
        $product = Product::where('slug', $slug)->where('status', '1')->firstOrFail();
        $Products = Product::where('id', '!=', $product->id)->where('category_id', $product->category_id)->where('status', '1')->where('qty','>','0')->orderBy('id', 'desc')->limit(6)->get();

        $kategori = Category::where('id', $product->category_id)->with('category:id,name,slug')->first();

        $Breadcrumb['active'] = $product->name;

        $Breadcrumb['sayfalar'][] = [
            'link' => route('urunler'),
            'name' => 'Ürünler',
        ];

        if (!empty($kategori->category->slug)) {
            $Breadcrumb['sayfalar'][] = [
                'link' => route($kategori->category->slug . 'urunler'),
                'name' => $kategori->category->name,
            ];

            $Breadcrumb['sayfalar'][] = [
                'link' => route($kategori->category->slug . 'urunler', $kategori->slug),
                'name' => $kategori->name,
            ];
        }


        // indirim
        $discounts = Coupon::where('status', '1')->where('isDiscount', '1')->where('qty','>','0')->get();

        //seo

        $keywords = $kategori->name . ',' . $kategori->content . ',' . $product->size . ',' . $product->name . ',' . $product->color;

        $seo = [
            'title' => config('app.name') . ' | ' . $product->name ?? '',
            'description' => $product->short_text ?? '',
            'keywords' => $product->keywords ?? '',
            'image' => asset($product->image),
            'url' => route('urundetay', $product->slug),
            'canonical' => route('urundetay', $product->slug),
            'robots' => 'index,follow',
        ];

        return view('frontend.pages.product', compact('seo', 'product', 'Products', 'Breadcrumb', 'discounts'));
    }
    public function urunler(Request $request, $slug = null)
    {

        $category = request()->segment(1) ?? null;
        $size = !empty($request->size) ? explode(',', $request->size) : null;
        $color = !empty($request->color) ? explode(',', $request->color) : null;
        $start_price = $request->min ?? null;
        $end_price = $request->max ?? null;

        $order = $request->order ?? 'id';
        $sort = $request->sort ?? 'desc';


        $anakategori = null;
        $altkategori = null;

        if (!empty($category) && empty($slug)) {
            $anakategori = Category::where('slug', $category)->first();
        } else if (!empty($category) && !empty($slug)) {
            $anakategori = Category::where('slug', $category)->first();
            $altkategori = Category::where('slug', $slug)->first();
        }

        $Breadcrumb = [
            'sayfalar' => [],
            'active' => 'Ürünler'
        ];

        if (!empty($anakategori) && empty($altkategori)) {
            $Breadcrumb['active'] = $anakategori->name;
            $Breadcrumb['sayfalar'][] = [
                'link' => route('urunler'),
                'name' => 'Ürünler',
            ];
        }

        if (!empty($altkategori)) {
            $Breadcrumb['sayfalar'][] = [
                'link' => route($anakategori->slug . 'urunler'),
                'name' => $anakategori->name,
            ];
            $Breadcrumb['active'] = $anakategori->name . ' ' . $altkategori->name;
        }

        $products = Product::where('status', '1')->select(['id', 'name', 'slug', 'size', 'color', 'price', 'category_id', 'short_text','qty'])
        ->where('qty','>','0')
            ->where(
                function ($q) use ($size, $color, $start_price, $end_price) {
                    if (!empty($size)) {
                        $q->whereIn('size', $size);
                    }
                    if (!empty($color)) {
                        $q->whereIn('color', $color);
                    }

                    if (!empty($start_price) && !empty($end_price)) {
                        $q->whereBetween('price', [$start_price, $end_price]);
                    }

                    return $q;
                }
            )->with('category:id,name,slug')
            ->whereHas('category', function ($q) use ($category, $slug) {
                if (!empty($slug)) {
                    $q->where('slug', $slug);
                }
                return $q;
            })->orderBy($order, $sort)
            ->with('images')
            ->paginate(21);

        if ($request->ajax()) {
            $view = view('frontend.ajax.productList', compact('products'))->render();
            return response(['data' => $view, 'paginate' => (string) $products->withQueryString()->links('vendor.pagination.bootstrap-4')]);
        }


        $maxprice = Product::where('qty','>','0')->max('price');
        $sizeLists = Product::where('status', '1')->where('qty','>','0')->groupBy('size')->pluck('size')->toArray();
        $colors = Product::where('status', '1')->where('qty','>','0')->groupBy('color')->pluck('color')->toArray();

        // indirim
        $discounts = Coupon::where('status', '1')->where('isDiscount', '1')->where('qty','>','0')->get();

        // seo

        $seoLists = metaolustur($category);

        $seo = [
            'title' => $seoLists['title'] ?? config('app.name') . ' | Ürünler',
            'description' => $seoLists['description'] ?? config('app.name') . ' | Ürünler Açıklama',
            'keywords' => $seoLists['keywords'] ?? config('app.name') . ', kadın, erkek, çocuk, giyim, ayakkabı, çanta, aksesuar',
            'image' => asset('img/page-bg.jpg'),
            'url' => $seoLists['currenturl'] ?? null,
            'canonical' => $seoLists['trpage'] ?? null,
            'robots' => 'index,follow',
        ];

        return view('frontend.pages.products', compact('seo', 'Breadcrumb', 'products', 'maxprice', 'sizeLists', 'colors', 'discounts','slug'));
    }

    public function iletisim()
    {
        $Breadcrumb = [
            'sayfalar' => [],
            'active' => 'İletişim'
        ];

        $seoLists = metaolustur('iletisim');

        $seo = [
            'title' => $seoLists['title'] ?? config('app.name') . ' | İletişim',
            'description' => $seoLists['description'] ?? config('app.name') . ' İletişim sayfası',
            'keywords' => $seoLists['keywords'] ?? config('app.name') . ', iletişim, soru, cevap',
            'image' => asset('img/page-bg.jpg'),
            'url' => $seoLists['currenturl'] ?? null,
            'canonical' => $seoLists['trpage'] ?? null,
            'robots' => 'index,follow',
        ];

        return view('frontend.pages.contact', compact('seo', 'Breadcrumb'));
    }

}
