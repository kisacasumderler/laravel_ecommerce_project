<?php
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ImageUploadController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SpecialOfferController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['panelsetting','auth'],'prefix'=>'panel','as'=>'panel.'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('panel');

    Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');

    Route::get('/slider/ekle', [SliderController::class, 'create'])->name('slider.create');
    Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
    Route::post('/slider/store', [SliderController::class, 'store'])->name('slider.store');
    Route::put('/slider/{id}/update', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/slider/destroy', [SliderController::class, 'destroy'])->name('slider.destroy');

    Route::post('/slider-durum/status/update', [SliderController::class, 'statusUpdate'])->name('slider.status');

    Route::resource('/category',CategoryController::class)->except('destroy')->except('update');
    Route::delete('/category/destroy',[CategoryController::class,'destroy'])->name('category.destroy');
    Route::post('/category-durum/status/update', [CategoryController::class, 'statusUpdate'])->name('category.status');
    Route::put('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');

    Route::get('/about',[AboutController::class,'index'])->name('about.index');
    Route::post('about/update',[AboutController::class,'update'])->name('about.update');

    Route::get('/contact',[ContactController::class,'index'])->name('contact.index');
    Route::get('/contact/{id}/edit',[ContactController::class,'edit'])->name('contact.edit');
    Route::put('/contact/{id}/update',[ContactController::class,'update'])->name('contact.update');
    Route::delete('/contact/destroy', [ContactController::class, 'destroy'])->name('contact.destroy');
    Route::post('/contact-durum/status/update', [ContactController::class, 'statusUpdate'])->name('contact.status');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/store', [SettingController::class, 'store'])->name('setting.store');
    Route::get('/setting/create', [SettingController::class, 'create'])->name('setting.create');
    Route::delete('/setting/destroy', [SettingController::class, 'destroy'])->name('setting.destroy');
    Route::get('/setting/{id}/edit', [SettingController::class, 'edit'])->name('setting.edit');
    Route::put('/setting/{id}/update', [SettingController::class, 'update'])->name('setting.update');


    Route::resource('/product',ProductController::class)->except('destroy')->except('update');
    Route::delete('/product/destroy',[ProductController::class,'destroy'])->name('product.destroy');
    Route::post('/product-durum/status/update', [ProductController::class, 'statusUpdate'])->name('product.status');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');

    Route::get('/offer',[SpecialOfferController::class,'index'])->name('offer.index');
    Route::post('offer/update',[SpecialOfferController::class,'update'])->name('offer.update');
    Route::post('/offer-durum/status/update', [SpecialOfferController::class, 'statusUpdate'])->name('offer.status');

    Route::get('/order',[OrderController::class,'index'])->name('order.index');
    Route::get('/order/{id}/edit',[OrderController::class,'edit'])->name('order.edit');


    Route::get('/order/{id}/generate-pdf',[OrderController::class,'generatePDF'])->name('generate.pdf');



    Route::put('/order/{id}/update',[OrderController::class,'update'])->name('order.update');
    Route::delete('/order/destroy', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::post('/order-durum/status/update', [OrderController::class, 'statusUpdate'])->name('order.status');


    Route::post('/image-gorsel/vitrin', [ImageUploadController::class,'vitrin'])->name('vitrin.yap');
    Route::delete('/image-gorsel/destroy', [ImageUploadController::class,'destroy'])->name('image.resimsil');
});

?>
