<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {

        $cartItem = cartItem();
        $Breadcrumb = [
            'sayfalar' => [],
            'active' => 'Sepet'
        ];

        return view('frontend.pages.cart', compact('Breadcrumb','cartItem'));
    }

    public function sepetform()
    {
        $cartItem = cartItem();
        $Breadcrumb['active'] = 'Ödeme';

        $Breadcrumb['sayfalar'][] = [
            'link' => route('sepet'),
            'name' => 'Sepet',
        ];
        return view('frontend.pages.cartform', compact('Breadcrumb','cartItem'));
    }

    public function add(Request $request)
    {
        $productID = $request->product_id;
        $qty = $request->qty ?? 1;
        $size = $request->size;

        $urun = Product::find($productID);

        if (!$urun) {
            return back()->withError('Ürün Bulunamadı');
        }

        $cartItem = session('cart', []);

        if (array_key_exists($productID, $cartItem)) {
            $cartItem[$productID]['qty'] += $qty;
        } else {
            $cartItem[$productID] = [
                'image' => $request->urunImg,
                'name' => $urun->name,
                'price' => $urun->price,
                'qty' => $qty,
                'size' => $size,
                'kdv' => $urun->kdv ?? 0,
            ];
        }

        session(['cart' => $cartItem]);

        return back()->withSuccess('Ürün Sepete Eklendi');
    }

    function newQty(Request $request)
    {
        $productID = $request->product_id;
        $qty = $request->qty ?? 0;
        $size = $request->size;

        $urun = Product::find($productID);
        if (!$urun) {
            return back()->withError('Ürün Bulunamadı');
        }

        $cartItem = session('cart', []);

        if (array_key_exists($productID, $cartItem)) {
            $cartItem[$productID]['qty'] = $qty;
            if ($qty == 0 || $qty < 0) {
                unset($cartItem[$productID]);
            }

        } else {
            $cartItem[$productID] = [
                'image' => $urun->image,
                'name' => $urun->name,
                'price' => $urun->price,
                'qty' => $qty,
                'size' => $size,
            ];
        }

        session(['cart' => $cartItem]);

        if ($request->ajax()) {
            return response()->json(['cartItem' => $cartItem, 'message' => 'Sepet Güncellendi']);
        }
    }

    public function remove(Request $request)
    {
        $productID = sifrecoz($request->product_id);
        $cartItem = session('cart', []);
        if (array_key_exists($productID, $cartItem)) {
            unset($cartItem[$productID]);
        }
        session(['cart' => $cartItem]);

        if($request->ajax()) {
            return response()->json(['sepetCount'=>count(session()->get('cart')),'message'=>'Ürün Sepetten Kaldırıldı!']);
        }

        return back()->withSuccess('Ürün Sepetten Kaldırıldı!');
    }

    public function couponcheck(Request $request)
    {
        /* return $request->all(); */
        $kupon = Coupon::where('name', $request->coupon_name)->first();
        $kuponKod = $request->coupon_name ?? '';
        $indirim = $kupon->price ?? 0;


        $cartItem = session('cart', []);
        $totalPrice = 0;
        foreach ($cartItem as $cart) {
            $totalPrice += $cart['price'] * $cart['qty'];
        }

        $newTotalPrice = $totalPrice - $indirim;

        session()->put('total_price', $newTotalPrice);
        session()->put('coupon_code', $kuponKod);


        if (empty($kupon)) {
            session()->put('total_price', $totalPrice);
            session()->forget('kupon_price');
            return back()->withError('Kupon Bulunamadı');
        }
        return back()->withSuccess('indirim Uygulandı');

    }

    public function cartSave(Request $request)
    {

        $request->validate(
            [
                'c_country' => 'required|string',
                'c_name' => 'required|string|min:3',
                'c_companyname' => 'nullable|string',
                'c_city' => 'required|string',
                'c_address' => 'required|string',
                'c_state_country' => 'required|string',
                'c_postal_zip' => 'required|numeric',
                'c_email_address' => 'required|email',
                'c_phone' => 'required|numeric',
                'order_note' => 'string',
            ],
            [
                'c_country.required' => 'Müşteri Ülkesi alanı zorunludur.',
                'c_country.string' => 'Müşteri Ülkesi alanı metin formatında olmalıdır.',
                'c_name.required' => 'Müşteri Adı alanı zorunludur.',
                'c_name.string' => 'Müşteri Adı alanı metin formatında olmalıdır.',
                'c_name.min' => 'Müşteri Adı en az :min karakter uzunluğunda olmalıdır.',
                'c_companyname.string' => 'Müşteri Şirket Adı alanı metin formatında olmalıdır.',
                'c_city.required' => 'Müşteri Şehir alanı zorunludur.',
                'c_city.string' => 'Müşteri Şehir alanı metin formatında olmalıdır.',
                'c_address.required' => 'Müşteri Adresi alanı zorunludur.',
                'c_address.string' => 'Müşteri Adresi alanı metin formatında olmalıdır.',
                'c_state_country.required' => 'Müşteri Eyalet/Ülke alanı zorunludur.',
                'c_state_country.string' => 'Müşteri Eyalet/Ülke alanı metin formatında olmalıdır.',
                'c_postal_zip.required' => 'Müşteri Posta Kodu/ZİP alanı zorunludur.',
                'c_postal_zip.numeric' => 'Müşteri Posta Kodu/ZİP alanı sadece numerik değerlerden oluşmalıdır.',
                'c_email_address.required' => 'Müşteri E-posta Adresi alanı zorunludur.',
                'c_email_address.email' => 'Geçerli bir e-posta adresi giriniz.',
                'c_phone.required' => 'Müşteri Telefon alanı zorunludur.',
                'c_phone.numeric' => 'Müşteri Telefon alanı sadece numerik değerlerden oluşmalıdır.',
                'order_note.string' => 'Sipariş notu alanı metin formatında olmalıdır.',
            ]
        );

        $orderCode = generateOTP();


        $invoce = Invoice::create([
            "user_id" => auth()->user()->id ?? null,
            "order_no" => $orderCode,
            "c_country" => Guvenlik($request->c_country),
            "c_name" => Guvenlik($request->c_name),
            "c_companyname" => Guvenlik($request->c_companyname),
            "c_city" => Guvenlik($request->c_city),
            "c_address" => Guvenlik($request->c_address),
            "c_state_country" => Guvenlik($request->c_state_country),
            "c_postal_zip" => Guvenlik($request->c_postal_zip),
            "c_email_address" => Guvenlik($request->c_email_address),
            "c_phone" => Guvenlik($request->c_phone),
            "order_note" => Guvenlik($request->order_note)
        ]);

        $carts = session()->get('cart') ?? [];

        foreach ($carts as $key => $item) {
            Order::create([
                'order_no' => $invoce->order_no,
                'product_id' => $key,
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'kdv' => $item['kdv']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('sepet');
    }
}
