<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use PDF;
class OrderController extends Controller
{
    public function index() {
        $orders = Invoice::orderByDesc('id')->withCount('orders')->paginate(20);
        return view('backend.pages.order.index',compact('orders'));
    }
    public function edit($id) {
        $invoice = Invoice::where('id', $id)->with('orders')->firstOrFail();

        $data =  SiteSetting::all();
        $companyAddress =  $data->where('name', 'address')->value('data') ?? '';
        $companyLogo = $data->where('name', 'logo')->value('data') ?? '';

        return view('backend.pages.order.edit',compact('companyAddress', 'companyLogo', 'invoice'));
    }


    public function update (Request $request,$id) {

    }

    public function destroy(Request $request)
    {

        $order = Invoice::where('id', $request->id)->firstOrfail();
        Order::where('order_no',$order->order_no)->delete();

        $order->delete();
        return response(['error'=>false, 'message'=>'Başarıyla Silindi.']);
    }

    public function statusUpdate(Request $request) {
        $update = $request->statu;
        $updateCheck = $update == 'false' ? '0' : '1';
        Invoice::where('id',$request->id)->update(['status'=>$updateCheck]);
        return response(['error'=>false,'status'=>$updateCheck]);
    }
}

