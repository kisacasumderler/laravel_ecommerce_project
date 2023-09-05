@extends('frontend.layout.layout')
@section('content')
    @include('backend.inc.Breadcrumb')
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="border p-4 rounded" role="alert">
                        Returning customer? <a href="#">Click here</a> to login
                    </div>
                </div>
            </div>
            <form action="{{ route('sepet.save') }}" class="row" method="POST">
                @csrf
                <input type="hidden" name="kupon_price" value="{{ sifrele(session('kupon_price') ?? null) }}">
                <div class="col-md-6 mb-5 mb-md-0">
                    <h2 class="h3 mb-3 text-black">Ödeme Bilgileri</h2>
                    <div class="p-3 p-lg-5 border">
                        <div class="form-group">
                            <label for="c_country" class="text-black">Ülke<span class="text-danger">*</span></label>
                            @error('c_country')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <select id="c_country" class="form-control" name="c_country">
                                <option value="">Ülke Seçiniz</option>
                                <option value="{{ old('c_country') ?? 'Turkey' }}" selected>Türkiye</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="c_name" class="text-black">Ad Soyad<span class="text-danger">*</span></label>
                                @error('c_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input type="text" class="form-control" id="c_name" name="c_name"
                                    value="{{ old('c_name') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="c_companyname" class="text-black">Şirket Adı</label>
                                @error('c_companyname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input type="text" class="form-control" id="c_companyname" name="c_companyname"
                                    value="{{ old('c_companyname') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="c_city" class="text-black">Şehir<span class="text-danger">*</span></label>
                            @error('c_city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input id="c_city" name="c_city" type="text" class="form-control" placeholder="Şehir"
                                value="{{ old('c_city') }}">
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="c_address" class="text-black">Adres <span class="text-danger">*</span></label>
                                @error('c_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <textarea type="text" class="form-control" id="c_address" name="c_address" placeholder="Adres">{{ old('c_address') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="c_state_country" class="text-black">İlçe <span
                                        class="text-danger">*</span></label>
                                @error('c_state_country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input type="text" class="form-control" id="c_state_country" name="c_state_country"
                                    placeholder="ilçe" value="{{ old('c_state_country') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="c_postal_zip" class="text-black">Posta Kodu<span
                                        class="text-danger">*</span></label>
                                @error('c_postal_zip')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip"
                                    placeholder="Posta Kodu" value="{{ old('c_postal_zip') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <div class="col-md-6">
                                <label for="c_email_address" class="text-black">Email Address <span
                                        class="text-danger">*</span></label>
                                @error('c_email_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input type="email" class="form-control" id="c_email_address" name="c_email_address"
                                    placeholder="Email Adres" value="{{ old('c_email_address') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="c_phone" class="text-black">Telefon <span
                                        class="text-danger">*</span></label>
                                @error('c_phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input type="tel" class="form-control" id="c_phone" name="c_phone"
                                    placeholder="500XXXXXXX" value="{{ old('c_phone') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="order_note" class="text-black">Sipariş Notu <span
                                        class="text-danger">*</span></label>
                                @error('order_note')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <textarea type="text" class="form-control" id="order_note" name="order_note" placeholder="Adres">{{ old('order_note') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h2 class="h3 mb-3 text-black">İndirim Kuponu</h2>
                            <div class="p-3 p-lg-5 border">
                                <label for="c_code" class="text-black mb-3">Kupon kodunuz varsa burada
                                    gözükecektir.</label>
                                <div class="input-group w-75">
                                    <input type="text" class="form-control" id="c_code" placeholder="Kupon Kodu"
                                        aria-label="Coupon Code" aria-describedby="button-addon2"
                                        value="{{ session()->get('coupon_code') }}" readonly>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h2 class="h3 mb-3 text-black">Your Order</h2>
                            <div class="p-3 p-lg-5 border">
                                <table class="table site-block-order-table mb-5">
                                    <thead>
                                        <th>Ürün</th>
                                        <th>Toplam Fiyat</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $toplamKDV = 0;
                                            $toplamIndirim = 0;
                                        @endphp
                                        @if (session()->get('cart'))
                                            @foreach (session()->get('cart') as $key => $cart)
                                                @if ($cart['qty'] > 0)
                                                    <tr>
                                                        <td>{{ $cart['name'] }} <strong
                                                                class="mx-2">x</strong>{{ $cart['qty'] }}</td>
                                                        <td>{{ number_format($cart['price'], 2) }}₺</td>
                                                    </tr>
                                                    @if ($cart['discountAmount'] > 0)
                                                        @php
                                                            $toplamIndirim += $cart['discountAmount'];
                                                        @endphp
                                                        <tr>
                                                            <td>Ürün İndirimi</td>
                                                            <td class="text-danger">-{{ $cart['discountAmount'] }}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        @php
                                                            $toplamKDV += ($cart['kdv'] ?? 0) * $cart['qty'];
                                                        @endphp
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if (session()->get('kupon_price') > 0)
                                            @php
                                                $toplamIndirim += session('kupon_price');
                                            @endphp
                                            <tr>
                                                <td class="text-black ">Kupon İndirimi
                                                </td>
                                                <td class="text-danger">
                                                    -{{ number_format(session()->get('kupon_price'), 2) }}₺
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="text-black font-weight-bold">Toplam KDV</td>
                                            <td class="text-black">{{ number_format($toplamKDV, 2) }}₺
                                            </td>
                                        </tr>
                                        @if ($toplamIndirim > 0)
                                            <tr>
                                                <td class="text-black font-weight-bold">Toplam İndirim</td>
                                                <td class="text-black font-weight-bold">-{{ $toplamIndirim }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Sepet Toplamı</strong></td>
                                            <td class="text-black">
                                                {{ number_format(session()->get('total_price') + session()->get('kupon_price'), 2) }}₺
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Toplam Tutar</strong>
                                            </td>
                                            <td class="text-black font-weight-bold">
                                                <strong> {{ number_format(session()->get('total_price'), 2) }}₺</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg py-3 btn-block"
                                        onclick="window.location='thankyou.html'">Ödemeye Devam Et</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <!-- </form> -->
        </div>
    </div>
@endsection

@section('customjs')
@endsection
