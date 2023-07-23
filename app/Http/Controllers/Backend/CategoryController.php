<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;



class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('category:id,cat_ust,name')->get();

        return view('backend.pages.category.index', compact('categories'));
    }
    public function create()
    {

        $categories = Category::where('status', '1')->get();
        return view('backend.pages.category.edit', compact('categories'));
    }
    public function store(CategoryRequest $request)
    {


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $yol = 'images\category\\';
            $dosyaTamad = resimyukle($image, 800, 950, $yol);
        }

        Category::create(
            [
                'image' => $dosyaTamad ?? null,
                'cat_ust' => Guvenlik($request->cat_ust),
                'name' => Guvenlik($request->name),
                'content' => Guvenlik($request->content),
                'status' => Guvenlik($request->status),
            ]
        );

        return back()->withSuccess('Başarıyla Oluşturuldu');
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        $categories = Category::where('status', '1')->get();
        return view('backend.pages.category.edit', compact('category', 'categories'));
    }
    public function update(CategoryRequest $request, $id)
    {

        $query = Category::where('id', $request->id);
        $category = $query->firstOrfail();
        $fileName = $query->first()->image ?? null;


        if ($request->cat_ust == null ) {
            if ($request->hasFile('image')) {
                dosyasil($category->image);
                $image = $request->file('image');
                $yol = 'images\category\\';
                $dosyaTamad = resimyukle($image, 900, 1182, $yol);
            }
        } else {
            if ($request->hasFile('image')) {
                dosyasil($category->image);
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $yol = 'images\category\\';
                    $dosyaTamad = resimyukle($image, 800, 950, $yol);
                }
            }
        }

        Category::where('id', $id)->update(
            [
                'image' => $dosyaTamad ?? $fileName,
                'cat_ust' => Guvenlik($request->cat_ust),
                'name' => Guvenlik($request->name),
                'content' => Guvenlik($request->content),
                'status' => Guvenlik($request->status),
            ]
        );

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
