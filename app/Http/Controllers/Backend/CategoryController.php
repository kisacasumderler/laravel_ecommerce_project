<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('category:id,cat_ust,name')->with('images')->get();
        return view('backend.pages.category.index', compact('categories'));
    }
    public function create()
    {
        $categories = Category::where('status', '1')->get();
        return view('backend.pages.category.edit', compact('categories'));
    }
    public function store(CategoryRequest $request)
    {
       $category = Category::create(
            [
                'cat_ust' => Guvenlik($request->cat_ust),
                'name' => Guvenlik($request->name),
                'content' => Guvenlik($request->content),
                'status' => Guvenlik($request->status),
            ]
        );

        if($request->hasFile('image')) {
            $this->fileSave('Category','kategori',$request,$category);
        }

        return back()->withSuccess('Başarıyla Oluşturuldu');
    }
    public function edit($id)
    {
        $category = Category::where('id', $id)->with('images')->first();
        $categories = Category::where('status', '1')->get();
        return view('backend.pages.category.edit', compact('category', 'categories'));
    }
    public function update(CategoryRequest $request, $id)
    {

        $query = Category::where('id', $request->id);
        $category = $query->firstOrfail();
        $category->update(
            [
                'cat_ust' => Guvenlik($request->cat_ust),
                'name' => Guvenlik($request->name),
                'content' => Guvenlik($request->content),
                'status' => Guvenlik($request->status),
            ]
        );

        if($request->hasFile('image')) {
            $this->fileSave('Category','kategori',$request,$category);
        }

        return back()->withSuccess('Başarıyla Güncellendi');
    }
    public function destroy(Request $request)
    {

        $category = Category::where('id', $request->id)->firstOrfail();
        dosyasil($category->image);
        dosyasil($category->MobileImage);

        $category->delete();
        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    public function statusUpdate(Request $request)
    {
        $update = $request->statu;
        $updateCheck = $update == 'false' ? '0' : '1';
        Category::where('id', $request->id)->update(['status' => $updateCheck]);
        return response(['error' => false, 'status' => $updateCheck]);
    }
}
