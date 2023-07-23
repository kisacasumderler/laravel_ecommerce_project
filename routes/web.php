<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\frontend\PageController;
use App\Http\Controllers\frontend\PageHomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'sitesetting'], function () {
    Route::get('/', [PageHomeController::class, 'anasayfa'])->name('anasayfa');
    Route::get('/hakkimizda', [PageController::class, 'hakkimizda'])->name('hakkimizda');

    Route::get('/iletisim', [PageController::class, 'iletisim'])->name('iletisim');
    Route::post('/iletisim/kaydet', [AjaxController::class, 'iletisimkaydet'])->name('iletisim.kaydet');

    Route::get('/urunler', [PageController::class, 'urunler'])->name('urunler');
    Route::get('/erkek/{slug?}', [PageController::class, 'urunler'])->name('erkekurunler');
    Route::get('/kadin/{slug?}', [PageController::class, 'urunler'])->name('kadinurunler');
    Route::get('/cocuk/{slug?}', [PageController::class, 'urunler'])->name('cocukurunler');
    Route::get('/indirimdekiler', [PageController::class, 'indirimdekiurunler'])->name('indirimdekiurunler');
    Route::get('/urun/{slug}', [PageController::class, 'urundetay'])->name('urundetay');

    Route::get('/sepet', [CartController::class, 'index'])->name('sepet');

    Route::get('/sepet/form', [CartController::class, 'sepetform'])->name('sepet.form');

    Route::post('/sepet/ekle', [CartController::class, 'add'])->name('sepet.add');
    Route::post('/sepet/newQty', [CartController::class, 'newQty'])->name('sepet.newQty');
    Route::post('/sepet/remove', [CartController::class, 'remove'])->name('sepet.remove');
    Route::post('/sepet/kaydet', [CartController::class, 'cartSave'])->name('sepet.save');

    Route::post('/sepet/couponcheck', [CartController::class, 'couponcheck'])->name('coupon.check');

    Auth::routes();

    Route::get('/cikis', [AjaxController::class, 'logout'])->name('cikis');

    // coupon.check
});
