<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function hakkimizda()
    {
        $about = About::where('id', '1')->first();
        return view('frontend.pages.about', compact('about'));
    }
    public function urundetay($slug)
    {
        $product = Product::where('slug', $slug)->where('status', '1')->firstOrFail();
        $Products = Product::where('id', '!=', $product->id)->where('category_id', $product->category_id)->where('status', '1')->orderBy('id','desc')->limit(6)->get();
        return view('frontend.pages.product', compact('product', 'Products'));
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


        $products = Product::where('status', '1')->select(['id', 'name', 'slug', 'size', 'color', 'price', 'image', 'category_id', 'short_text'])
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
            })->orderBy($order, $sort)->paginate(21);

        if($request->ajax()) {
            $view = view('frontend.ajax.productList',compact('products'))->render();
            return response(['data'=>$view,'paginate'=>(string) $products->withQueryString()->links('vendor.pagination.bootstrap-4')]);
        }

        $maxprice = Product::max('price');
        $sizeLists = Product::where('status', '1')->groupBy('size')->pluck('size')->toArray();
        $colors = Product::where('status', '1')->groupBy('color')->pluck('color')->toArray();


        return view('frontend.pages.products', compact('products', 'maxprice', 'sizeLists', 'colors'));
    }

    public function indirimdekiurunler()
    {
        return view('frontend.pages.products');
    }

    public function iletisim()
    {
        return view('frontend.pages.contact');
    }

}
