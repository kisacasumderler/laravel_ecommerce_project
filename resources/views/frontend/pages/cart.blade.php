@extends('frontend.layout.layout')
@section('content')
    @include('backend.inc.Breadcrumb')
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12">
                    @if (session()->get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="alert-success">{{ session()->get('success') }}</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12">
                    @if (session()->get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="alert-danger">{{ session()->get('error') }}</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="col-md-12"> {{-- formdu --}}
                    <div class="site-blocks-table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Resim</th>
                                    <th class="product-name">İsim</th>
                                    <th class="product-price">Tutar</th>
                                    <th class="product-quantity">Adet</th>
                                    <th>Beden</th>
                                    <th class="product-total">Toplam Tutar</th>
                                    <th class="product-remove">Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($cartItem)
                                    @foreach ($cartItem as $key => $cart)
                                        <tr class="orderItem product{{ $key }}" data-id="{{ $key }}"
                                            style="display: {{ $cart['qty'] == 0 ? 'none;' : '' }}">
                                            <td class="product-thumbnail">
                                                <img src="{{ asset($cart['image']) }}" alt="Image" class="img-fluid">
                                            </td>
                                            <td class="product-name">
                                                <h2 class="h5 text-black">{{ $cart['name'] ?? '' }}</h2>
                                            </td>
                                            <td class="productPrice">{{ number_format($cart['price'], 2) }}₺</td>
                                            <td>
                                                <div class="input-group mb-3" style="max-width: 120px;">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-outline-primary js-btn-minus minusBtn"
                                                            type="button">&minus;</button>
                                                    </div>
                                                    <input type="text" class="form-control text-center qtyItem"
                                                        value="{{ $cart['qty'] }}" placeholder=""
                                                        aria-label="Example text with button addon"
                                                        aria-describedby="button-addon1">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary js-btn-plus plusBtn"
                                                            type="button">&plus;</button>
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                {{ $cart['size'] }}
                                            </td>
                                            <td class="ProductTotalPrice">
                                                {{ number_format($cart['price'] * $cart['qty'], 2) }}₺</td>
                                            <td>
                                                <form method="POST" class="removeItem">
                                                    @csrf
                                                    @php
                                                        $sifrele = sifrele($key);
                                                    @endphp
                                                    <input type="hidden" name='product_id' value="{{ $sifrele }}">
                                                    <button type="submit" class="btn btn-primary btn-sm">X</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <button class="btn btn-primary btn-sm btn-block refreshCart">Sepeti Güncelle</button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('urunler')}}" class="btn btn-outline-primary btn-sm btn-block">Alışverişe Devam Et</a>
                        </div>
                    </div>
                    <form class="row" method="POST" action="{{ route('coupon.check') }}">
                        @csrf
                        <div class="col-md-12">
                            <label class="text-black h4" for="coupon">Hediye Kupon</label>
                            <p>Kupon kodunuz varsa buraya giriniz.</p>
                        </div>
                        <div class="col-md-8 mb-3 mb-md-0">
                            <input type="text" class="form-control py-3" id="coupon" name="coupon_name"
                                placeholder="Coupon Code" value="{{ session()->get('coupon_code') ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-sm">Kupon kodu Onayla</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-right border-bottom mb-5">
                                    <h3 class="text-black h4 text-uppercase">Sepet Toplamı</h3>
                                </div>
                            </div>
                            @if (session('coupon_code') && session('kupon_price'))
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        indirim Tutar :
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-danger couponPrice">-{{ session('kupon_price') }}₺</strong>
                                    </div>
                                </div>
                            @endif
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <span class="text-black">Toplam Tutar</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong
                                        class="text-black cartTotalPrice">{{ number_format(session()->get('total_price'), 2) }}₺</strong>
                                </div>
                            </div>
                            <div class="row">
                                @if (!empty(session()->get('cart')))
                                    <div class="col-md-12">
                                        <button class="btn btn-primary btn-lg py-3 btn-block paymentButton">Ödemeye
                                            Geç</button>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.refreshCart', function(e) {
                location.reload();
            })

            $(document).on('click', '.paymentButton', function(e) {
                let url = "{{ route('sepet.form') }}";
                @if (!empty(session()->get('cart')))
                    window.location.href = url;
                @endif
            });
            $(document).on('click', '.minusBtn', function(e) {
                sepetUpdate($(this));
            });
            $(document).on('click', '.plusBtn', function(e) {

                sepetUpdate($(this));
            });

            function sepetUpdate(param) {
                let product_id = $(param).closest('.orderItem').attr('data-id');
                let qty = $(param).closest('.orderItem').find('.qtyItem').val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ url('sepet/newQty') }}",
                    data: {
                        product_id: product_id,
                        qty: qty
                    },
                    success: function(response) {

                        let responseData = response.cartItem;
                        alertify.success(response.message)

                        var totalCartPrice = 0;
                        for (var id in responseData) {
                            if (responseData.hasOwnProperty(id)) {
                                var item = responseData[id];
                                var qty = item.qty;
                                var price = item.price;
                                var totalPrice = qty * price;

                                if (qty == 0 || qty < 0) {
                                    $('.product' + id).remove();
                                }

                                totalCartPrice += totalPrice;
                                $('.product' + id).find('.productPrice').text(formatNumber(price));
                                $('.product' + id).find('.ProductTotalPrice').text(formatNumber(
                                    totalPrice));

                            }
                        }

                        let kupon = parseInt("{{ session('kupon_price') ?? '0' }}");
                        totalCartPrice = totalCartPrice - kupon;

                        $('.cartTotalPrice').text(formatNumber(totalCartPrice))
                    }
                });
            }


            function formatNumber(number) {
                return number.toFixed(2) + '₺';
            }

            $(document).on('click', '.removeItem', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                var item = $(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('sepet.remove') }}",
                    data: formData,
                    success: function(response) {
                        toastr.success(response.message);
                        $('.count').text(response.sepetCount);
                        item.closest('.orderItem').remove();
                    }
                })
            })

        });
    </script>
@endsection
