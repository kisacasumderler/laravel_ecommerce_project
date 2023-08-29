<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category:id,cat_ust,name')->with('images')->orderByDesc('id')->paginate(20);

        return view('backend.pages.product.index', compact('products'));
    }

    public function create()
    {

        $categories = Category::where('status', '1')->with('images')->get();
        return view('backend.pages.product.edit', compact('categories'));
    }

    public function store(ProductRequest $request)
    {


        $product = Product::create(
            [
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

        if($request->hasFile('image')) {
            $this->fileSave('Product','product',$request,$product);
        }

        return back()->withSuccess('Başarıyla Oluşturuldu');
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        $categories = Category::where('status', '1')->get();
        return view('backend.pages.product.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, $id)
    {

        $query = Product::where('id', $request->id);
        $product = $query->firstOrfail();

        Product::where('id', $id)->update(
            [
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

        if($request->hasFile('image')) {
            $this->fileSave('Product','product',$request,$product);
        }

        return back()->withSuccess('Başarıyla Güncellendi');
    }

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
