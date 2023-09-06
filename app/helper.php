<?php
use App\Models\Coupon;
use App\Models\Product;

function Guvenlik($Deger)
{
    $BoslukSil = trim($Deger);
    $TaglariTemizle = strip_tags($BoslukSil);
    $EtkisizYap = htmlspecialchars($TaglariTemizle, ENT_QUOTES);
    $Sonuc = $EtkisizYap;
    return $Sonuc;
}

function cartItem()
{
    $cartItem = session('cart', []);
    $totalPrice = 0;
    foreach ($cartItem as $cart) {
        $totalPrice += $cart['price'] * $cart['qty'];
    }
    if (session()->get('coupon_code')) {
        $kupon = Coupon::where('name', session()->get('coupon_code'))->where('status', '1')->first();
        $kuponTutar = $kupon->price ?? 0;
        session()->put('kupon_price', $kuponTutar);
        $newTotalPrice = $totalPrice - $kuponTutar;
    } else {
        $newTotalPrice = $totalPrice;
    }

    session()->put('total_price', $newTotalPrice);
    return $cartItem;
}

function kdvHesapla($price, $kdv = 0)
{
    return (($price * $kdv) / 100);
}

function DonusumleriGeriDondur($Deger)
{
    $GeriDondur = htmlspecialchars_decode($Deger, ENT_QUOTES);
    $Sonuc = $GeriDondur;
    return $Sonuc;
}

if (!function_exists('generateOTP')) {
    function generateOTP()
    {
        $deger = strtoupper(substr(md5(uniqid(time())), 0, 10));
        return $deger;
    }
}

if (!function_exists('dosyasil')) {
    function dosyasil($string)
    {
        if (file_exists($string)) {
            if (!empty($string)) {
                if (!File::isDirectory($string)) {
                    File::makeDirectory($string, 0777, true, true);
                }
                unlink($string);
            }
        }
    }
}


if (!function_exists('dosyaizin')) {
    function dosyaizin($string)
    {
        if (file_exists($string)) {
            if (!empty($string)) {
                if (!File::isDirectory($string)) {
                    File::makeDirectory($string, 0777, true, true);
                }
            }
        }
    }
}

if (!function_exists('klasorac')) {
    function klasorac($dosyayol, $izinler = 0777)
    {
        if (!file_exists($dosyayol)) {
            mkdir($dosyayol, $izinler, true);
        }
    }
}


if (!function_exists('resimyukle')) {
    function resimyukle($image, $x, $y, $yol)
    {
        $uzanti = $image->getClientOriginalExtension();
        $dosyaadi = substr(md5(uniqid(time())), 0, 25);
        $image = Image::make($image)->resize($x, $y);
        $yukleKlasor = public_path($yol);

        if (!File::isDirectory($yukleKlasor)) {
            File::makeDirectory($yukleKlasor, 0777, true, true);
        }

        if ($uzanti == 'pdf' || $uzanti == 'svg' || $uzanti == 'webp') {
            $image->save($yukleKlasor . $dosyaadi . '.' . $uzanti);
            $dosyaTamad = $yol . $dosyaadi . '.' . $uzanti;
        } else {
            $image->encode('webp', 75)->save($yukleKlasor . $dosyaadi . '.webp');
            $dosyaTamad = $yol . $dosyaadi . '.webp';
        }

        return $dosyaTamad;
    }
}

if (!function_exists('strLimit')) {
    function strLimit($text, $limit, $url = null)
    {
        if ($url == null) {
            $end = '...';
        } else {
            $end = '<a class="p-0 px-1 btn btn-link" href="' . $url . '">[Devamını Gör]</a>';
        }
        return Str::limit($text, $limit, $end);
    }
}


use Illuminate\Support\Facades\Crypt;

function sifrele($content)
{
    $encryptedContent = Crypt::encryptString($content);
    return $encryptedContent;
}

function sifrecoz($encryptedContent)
{
    try {
        $decryptedContent = Crypt::decryptString($encryptedContent);
        return $decryptedContent;
    } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
        $hata = 'Şifre çözme işlemi başarısız oldu';
        return null;
    }
}


if (!function_exists('ozel_path')) {
    function ozel_path($dil = null, $url = null)
    {
        $dillink = (!empty($dil) && $dil != 'tr') ? $dil . '.' : (env('APP_ENV') == 'local' ? '' : 'www.');
        $urllink = (!empty($url)) ? '/' . $url : '';

        return config('app.app_ssl') . $dillink . config('app.url') . $urllink;
    }
}


if (!function_exists('metaolustur')) {
    function metaolustur($page)
    {
        $pageseo = \App\Models\PageSeo::where('page', $page)->with(['images', 'pages'])->first();
        if (!$pageseo) {
            return [];
        }

        $metalar = [];
        $title = $pageseo->title;
        $description = $pageseo->description;
        $keywords = $pageseo->keywords;

        foreach ($pageseo->pages as $pg) {
            if ($pg->dil === app()->getLocale()) {
                $title = $pg->title;
                $description = $pg->description;
                $keywords = $pg->keywords;
            } else {
                $metalar[] = ozel_path($pg->dil, $pg->page);
            }
        }

        $seoimg = collect($pageseo->images->data ?? '');
        $bgimg = $seoimg->sortByDesc('vitrin')->first()['image'] ?? '';
        $trpage = ozel_path('tr', $pageseo->page);

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'currenturl' => ozel_path(app()->getLocale(), $pageseo->page),
            'metalar' => $metalar,
            'bgimg' => $bgimg,
            'trpage' => $trpage,
        ];
    }
}

use Intervention\Image\ImageManagerStatic as Image;


if (!function_exists('uploadimage')) {
    function uploadimage($image, $pathyol, $paththumb = NULL, $with = NULL, $height = NULL)
    {

        $fullName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $onlyName = implode('', explode('.' . $extension, $fullName));
        $filename = Str::slug($onlyName) . '-' . time(); //generateOTP(6).'-'.time();

        if ($image->extension() == 'svg' || $image->extension() == 'webp' || $image->extension() == 'pdf' || $image->extension() == 'ico') {
            $orjinalurl = $pathyol . $filename . '.' . $image->extension();


            // \Illuminate\Support\Facades\Storage::disk('public')->putFileAs('', $image->path(), $orjinalurl);
            \Illuminate\Support\Facades\Storage::disk('public')->put($orjinalurl, Image::make($image->path())->encode('webp', 90));


            $imagear['orj'] = $orjinalurl;

            if (!empty($paththumb)) {
                $thumbnailurl = $orjinalurl;
                $imagear['thum'] = $thumbnailurl;
            } else {
                $imagear['thum'] = NULL;
            }

        } else {
            $orjinalurl = $pathyol . $filename . '.webp';
            // \Illuminate\Support\Facades\Storage::disk('public')->put($orjinalurl, \ImageResize::make($image->path())->encode('webp', 90));
            \Illuminate\Support\Facades\Storage::disk('public')->put($orjinalurl, Image::make($image->path())->encode('webp', 90));


            $imagear['orj'] = $orjinalurl;

            if (!empty($paththumb)) {

                $thumbnailurl = $paththumb . 'thumb_' . $filename . '.webp';
                // \Illuminate\Support\Facades\Storage::disk('public')->put($thumbnailurl, \ImageResize::make($image->path())
                //     ->resize($with, $height, function ($constraint) {
                //         $constraint->aspectRatio(); })
                //     ->encode('webp', 90));

                \Illuminate\Support\Facades\Storage::disk('public')->put($orjinalurl, Image::make($image->path())->encode('webp', 90));


                $imagear['thum'] = $thumbnailurl;
            } else {
                $imagear['thum'] = NULL;
            }


        }

        return $imagear;
    }
}


if (!function_exists('groupCategory')) {
    function groupCategory($categories, $parentId = null)
    {
        $result = [];

        foreach ($categories as $category) {
            if ($category['cat_ust'] == $parentId) {
                $subCat = groupCategory($categories, $category['id']);
                if (!empty($subCat)) {
                    $category['subCat'] = $subCat;
                }
                $result[] = $category;
            }
        }
        return $result;
    }
}
function recursiveCategoryPrint($categories, $slugNames = [])
{
    if (!empty($categories) && count($categories) > 0) {
        echo '<ul class= "dropdown">';
        echo '<li>';
        foreach ($categories as $category) {
            $currentNames = array_merge($slugNames, [$category->slug]);
            $url = url(reset($currentNames));

            if(count($currentNames) > 1) {
                $url = url(reset($currentNames),end($currentNames));
            }

            if (!is_string($category->subCat) && is_array($category->subCat) && count($category->subCat) > 0) {
                echo '<li class = "has-children"> <a href="' . $url . '" >' . $category->name . '</a>';
                recursiveCategoryPrint($category->subCat,  $currentNames);
                echo '</li>';
            } else {
                echo '<li > <a href="' . $url . '" >' . $category->name . '</a>';
                echo '</li>';
            }


        }
        echo '</li>';
        echo '</ul>';
    }
}


function recursiveCategoryPrintWithParent($categories, $parentNames = [], $selectedCategoryId = null)
{
    if (!empty($categories) && count($categories) > 0) {
        foreach ($categories as $category) {
            $currentNames = array_merge($parentNames, [$category->name]);
            $selected = ($category->id == $selectedCategoryId) ? 'selected' : '';
            echo '<option value="' . $category->id . '" ' . $selected . '>' . implode('->', $currentNames) . '</option>';

            if (!is_string($category->subCat)) {
                recursiveCategoryPrintWithParent($category->subCat, $currentNames, $selectedCategoryId);
            }
        }
    }
}


function disocuntControl($discounts, $product)
{
    $price = $product->price;
    $discountRate = 0;
    $couponName = null;
    $discountAmount = 0;

    foreach ($discounts as $discount) {
        if ($discount->category_id == '0' || $discount->category_id == $product->category_id) {
            $discountRate = $discount->discount_rate;
            $price = $price - (($discountRate * $price) / 100);
            $couponName = $discount->name;
            $discountAmount = $product->price - $price;
            break;
        }
    }

    return ['price' => $price, 'discountRate' => $discountRate,'couponName'=>$couponName, 'discountAmount'=>$discountAmount];
}


?>
