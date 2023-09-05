<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index () {
        $mounthTotalOrderCount = Order::where('created_at','>=',now()->subDays(30))->get()->count();
        $mounthTotalOrderPrice = Order::where('created_at','>=',now()->subDays(30))->get()->sum('price');

        $TotalOrderCount = Order::get()->count();
        $TotalOrderPrice = Order::get()->sum('price');

        $topProducts = Order::select('product_id',DB::raw('SUM(qty) as total_sold'))
        ->with('product:id,name')
        ->with(['product' => function ($q){
            $q->select(['id','name']);
            $q->with('images');
        }])
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->limit(10)
        ->get();


      return  $aggregatedData = Order::
        select(DB::raw('name, SUM(price * qty) as total_price, SUM(qty) as total_sold'))
    //  ->
        ->groupBy('name')
        ->limit(5)
        ->get();

        $labels = $aggregatedData->pluck('name');
        $total_price = $aggregatedData->pluck('total_price');
        $total_sold = $aggregatedData->pluck('total_sold');

        $data = [
            'labels' => $labels,
            'total_price' => $total_price,
            'total_sold' => $total_sold
        ];

        if(!empty($total_price) && $data['total_price'] != '[]') {

            $chartMaxPrice = max($data['total_price']->toArray());

        }else {

            $chartMaxPrice = 500;

        }

        return view('backend.pages.index',compact('mounthTotalOrderCount','mounthTotalOrderPrice','TotalOrderCount','TotalOrderPrice','topProducts','data','chartMaxPrice'));
    }
}
