<?php
use App\Models\Coupon;
use App\Models\Product;

function Guvenlik($Deger) {
    $BoslukSil = trim($Deger);
    $TaglariTemizle = strip_tags($BoslukSil);
    $EtkisizYap = htmlspecialchars($TaglariTemizle,ENT_QUOTES);
    $Sonuc = $EtkisizYap;
    return $Sonuc;
}

function cartItem() {
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

function kdvHesapla($price,$kdv=0) {
    return (($price * $kdv) / 100);
}

function DonusumleriGeriDondur($Deger) {
    $GeriDondur = htmlspecialchars_decode($Deger, ENT_QUOTES);
    $Sonuc = $GeriDondur;
    return $Sonuc;
}

if(!function_exists('generateOTP')) {
    function generateOTP() {
        $deger = strtoupper(substr(md5(uniqid(time())), 0, 10));
        return $deger;
    }
}

if(!function_exists('dosyasil')) {
    function dosyasil($string) {
        if(file_exists($string)){
            if(!empty($string)){
                if (!File::isDirectory($string)) {
                    File::makeDirectory($string, 0777, true, true);
                }
                unlink($string);
            }
        }
    }
}


if(!function_exists('dosyaizin')) {
    function dosyaizin($string) {
        if(file_exists($string)){
            if(!empty($string)){
                if (!File::isDirectory($string)) {
                    File::makeDirectory($string, 0777, true, true);
                }
            }
        }
    }
}


if(!function_exists('resimyukle')) {
    function resimyukle($image,$x,$y,$yol) {
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

if(!function_exists('strLimit')) {
    function strLimit ($text,$limit,$url = null) {
        if($url==null) {
            $end = '...';
        }else {
            $end = '<a class="p-0 px-1 btn btn-link" href="'.$url.'">[Devamını Gör]</a>';
        }
        return Str::limit($text,$limit,$end);
    }
}



?>
