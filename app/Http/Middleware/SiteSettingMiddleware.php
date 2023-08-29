<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;

class SiteSettingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $settings = SiteSetting::pluck('data', 'name')->toArray();

        $categories = Category::where('status', '1')->with('subCategory')->withCount('items')->with('images')->get();


        $cartItem = session('cart', []);
        $totalQty = 0;
        foreach ($cartItem as $cart) {
            $totalQty += $cart['qty'];
        }

        view()->share(['settings' => $settings, 'categories' => $categories, 'totalQty'=>$totalQty]);

        return $next($request);
    }
}
