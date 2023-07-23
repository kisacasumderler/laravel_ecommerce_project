<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category:id,cat_ust,name')->paginate(20);

        return view('backend.pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::where('status', '1')->get();
        return view('backend.pages.product.edit', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $yol = 'images\product\\';
            $dosyaTamad = resimyukle($image, 1200, 900, $yol);
        }

        Product::create(
            [
                'image' => $dosyaTamad ?? null,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'price' => ($request->tax_free_price + kdvHesapla($request->tax_free_price, $request->kdv)),
                'kdv' => $request->kdv,
                'tax_free_price' => $request->tax_free_price,
                'size' => $request->size,
                'color' => $request->color,
                'short_text' => $request->short_text,
                'content' => $request->content,
                'qty' => $request->qty,
                'status' => $request->status,
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
        $product = Product::where('id', $id)->first();
        $categories = Category::where('status', '1')->get();
        return view('backend.pages.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {

        $query = Product::where('id', $request->id);
        $product = $query->firstOrfail();
        $fileName = $query->first()->image ?? null;


        if ($request->hasFile('image')) {
            dosyasil($product->image);
            $image = $request->file('image');
            $yol = 'images\product\\';
            $dosyaTamad = resimyukle($image, 1200, 900, $yol);
        }

        Product::where('id', $id)->update(
            [
                'image' => $dosyaTamad ?? $fileName,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'price' => ($request->tax_free_price + kdvHesapla($request->tax_free_price, $request->kdv)),
                'kdv' => $request->kdv,
                'tax_free_price' => $request->tax_free_price,
                'size' => $request->size,
                'color' => $request->color,
                'short_text' => $request->short_text,
                'content' => $request->content,
                'qty' => $request->qty,
                'status' => $request->status,
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

        $product = Product::where('id', $request->id)->firstOrfail();
        dosyasil($product->image);
        dosyasil($product->MobileImage);

        $product->delete();
        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    public function statusUpdate(Request $request)
    {
        $update = $request->statu;
        $updateCheck = $update == 'false' ? '0' : '1';
        Product::where('id', $request->id)->update(['status' => $updateCheck]);
        return response(['error' => false, 'status' => $updateCheck]);
    }
}
