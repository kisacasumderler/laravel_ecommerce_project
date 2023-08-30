<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function index()
    {
        $coupons = Coupon::all();
        return view('backend.pages.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('backend.pages.coupons.edit');
    }

    public function store(Request $request)
    {

        $name = $request->name;
        $question = Coupon::where('name',$name)->first();
        if(!empty($question)) {
            return back()->withError('Zaten Kayıtlı!');
        }

        $couponArray = [];
        $couponArray['name'] = Guvenlik($request->name);
        $couponArray['price'] = Guvenlik($request->content);
        $couponArray['discount_rate'] = Guvenlik($request->link);
        $couponArray['status'] = Guvenlik($request->status);

        $coupon = Coupon::create($couponArray);

        return back()->withSuccess('Başarıyla Oluşturuldu');
    }

    public function edit($id)
    {
        $coupon = Coupon::where('id', $id)->first();
        return view('backend.pages.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {

        $name = $request->name;
        $question = Coupon::where('id','!=',$id)->where('name',$name)->first();
        if(!empty($question)) {
            return back()->withError('Zaten Kayıtlı!');
        }

        $query = Coupon::where('id', $request->id);
        $coupon = $query->firstOrfail();

        $couponArray = [];
        $couponArray['name'] = Guvenlik($request->name);
        $couponArray['price'] = Guvenlik($request->content);
        $couponArray['discount_rate'] = Guvenlik($request->link);
        $couponArray['status'] = Guvenlik($request->status);

        $coupon->update($couponArray);

        return back()->withSuccess('Başarıyla Güncellendi');
    }

    public function destroy(Request $request)
    {

        $coupon = Coupon::where('id', $request->id)->firstOrfail();
        $coupon->delete();
        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    public function statusUpdate(Request $request)
    {
        $update = $request->statu;
        $updateCheck = $update == 'false' ? '0' : '1';
        Coupon::where('id', $request->id)->update(['status' => $updateCheck]);
        return response(['error' => false, 'status' => $updateCheck]);
    }
}
