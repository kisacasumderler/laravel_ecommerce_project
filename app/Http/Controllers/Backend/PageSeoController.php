<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ImageMedia;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class PageSeoController extends Controller
{
    public function index()
    {
        $pageseos = PageSeo::with('images')->get();
        return view('backend.pages.pageseo.index', compact('pageseos'));
    }

    public function create()
    {
        return view('backend.pages.pageseo.edit');
    }

    public function store(Request $request)
    {
        $pagereq = $request->page;
        $sor = PageSeo::where('page', $pagereq)->first();

        if (!empty($sor)) {
            return back()->withSuccess('Zaten Kayıtlı Sayfa!');
        }

        $pageseoArray = [];
        $pageseoArray['dil'] = Guvenlik($request->dil);
        $pageseoArray['page'] = Guvenlik($request->page);
        $pageseoArray['page_ust'] = Guvenlik($request->page_ust);
        $pageseoArray['title'] = Guvenlik($request->title);
        $pageseoArray['description'] = Guvenlik($request->description);
        $pageseoArray['keywords'] = Guvenlik($request->keywords);
        $pageseoArray['contents'] = Guvenlik($request->contents);

        $pageseo = PageSeo::create($pageseoArray);

        if ($request->hasFile('image')) {
            $this->fileSave('Pageseo', 'pageseo', $request, $pageseo);
        }

        return back()->withSuccess('Başarıyla Oluşturuldu');
    }

    public function edit($id)
    {
        $pageseo = PageSeo::where('id', $id)->with('images')->first();
        return view('backend.pages.pageseo.edit', compact('pageseo'));
    }

    public function update(Request $request, $id)
    {
        $query = PageSeo::where('id', $request->id);
        $pageseo = $query->firstOrfail();

        $pagereq = $request->page;
        $sor = PageSeo::where('id', '!=', $pageseo->id)->where('page', $pagereq)->first();

        if (!empty($sor)) {
            return back()->withSuccess('Zaten Kayıtlı Sayfa!');
        }

        $pageseoArray = [];
        $pageseoArray['dil'] = Guvenlik($request->dil);
        $pageseoArray['page'] = Guvenlik($request->page);
        $pageseoArray['page_ust'] = Guvenlik($request->page_ust);
        $pageseoArray['title'] = Guvenlik($request->title);
        $pageseoArray['description'] = Guvenlik($request->description);
        $pageseoArray['keywords'] = Guvenlik($request->keywords);
        $pageseoArray['contents'] = Guvenlik($request->contents);

        $pageseo->update($pageseoArray);

        if ($request->hasFile('image')) {
            $this->fileSave('Pageseo', 'pageseo', $request, $pageseo);
        }

        return back()->withSuccess('Başarıyla Güncellendi');
    }

    public function destroy(Request $request)
    {

        $pageseo = PageSeo::where('id', $request->id)->firstOrfail();

        $imageMedia = ImageMedia::where('model_name', 'PageSeo')->where('table_id', $pageseo->id)->first();

        if (!empty($imageMedia->data)) {
            foreach ($imageMedia->data as $img) {
                dosyasil($img['image']);
            }
            $imageMedia->delete();
        }

        $pageseo->delete();

        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

}
