@php
    use Carbon\Carbon;
@endphp
@extends('backend.layout.app')
@section('customcss')
    <style>
        .invoice-box {
            max-width: 80%;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(n + 2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.item input {
            padding-left: 5px;
        }

        .invoice-box table tr.item td:first-child input {
            margin-left: -5px;
            width: 100%;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .invoice-box input[type="number"] {
            width: 60px;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial,
                sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
@endsection
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Sipariş Detay
                </h4>
                <form action="{{ route('panel.order.update', $invoice->id) }}" class="forms-sample" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (!empty($invoice->id))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <h4>Sipariş Kodu</h4>
                        <p class="p-1 bg-light text-dark">{{ DonusumleriGeriDondur($invoice->order_no) ?? '' }}</p>
                    </div>

                    <div class="form-group">
                        <h4>İsim Soyisim</h4>
                        <p class="p-1 bg-light text-dark">{{ DonusumleriGeriDondur($invoice->c_name) ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <h4>Telefon Numarası</h4>
                        <p class="p-1 bg-light text-dark">{{ DonusumleriGeriDondur($invoice->c_phone) ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <h4>Email Adres</h4>
                        <p class="p-1 bg-light text-dark">{{ $invoice->c_email_address ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <h4>Adres</h4>
                        <p class="p-1 bg-light text-dark">
                            {{ DonusumleriGeriDondur($invoice->c_address) ?? '' }}
                            {{ DonusumleriGeriDondur($invoice->c_state_country) ?? '' }} <br>
                            {{ DonusumleriGeriDondur($invoice->c_country) ?? '' }} /
                            {{ DonusumleriGeriDondur($invoice->c_city) ?? '' }} <br>
                            {{ DonusumleriGeriDondur($invoice->c_postal_zip) ?? '' }}
                        </p>
                    </div>
                    <div class="form-group">
                        <h4 for="icerik">Sipariş Notu</h4>
                        <p class="p-1 bg-light">
                            {{ DonusumleriGeriDondur($invoice->order_note) ?? '' }}
                        </p>
                    </div>

                    @empty(DonusumleriGeriDondur($invoice->c_companyname))
                        <div class="form-group">
                            <h4 for="icerik">Şirket Adı</h4>
                            <p class="p-1 bg-light">{{ DonusumleriGeriDondur($invoice->c_companyname) ?? '' }}</p>
                        </div>
                    @endempty
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    Ürün Adı
                                </th>
                                <th>
                                    Fiyat
                                </th>
                                <th>
                                    Adet
                                </th>
                                <th>
                                    KDV
                                </th>
                                <th>
                                    Toplam Tutar
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalPrice = 0;
                            @endphp
                            @if (!empty($invoice->orders) && $invoice->orders->count() > 0)
                                @foreach ($invoice->orders as $order)
                                    <tr class="item" item-id='{{ $order->id }}'>
                                        <td class="py-1">
                                            {{ $order['name'] ?? '' }}
                                        </td>
                                        <td class="text-wrap">
                                            {{ number_format($order['price'],2) ?? '0' }} ₺
                                        </td>
                                        <td class="text-wrap">
                                            {{ $order['qty'] ?? '0' }}
                                        </td>
                                        <td>{{ number_format($order['kdv'] * $order['qty'], 2) }}₺</td>
                                        <td>{{ number_format($order['price'] * $order['qty'] + $order['kdv'] * $order['qty'], 2) }}₺
                                        </td>
                                    </tr>
                                    @php
                                        $totalPrice += $order['price'] * $order['qty'] + $order['kdv'] * $order['qty'];
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="4"> Toplam Tutar: </td>
                                    <td colspan="1" class="bg-success text-white">{{ number_format($totalPrice,2)}}₺</td>
                                </tr>
                                @if (isset($order['kupon_price']) && $order['kupon_price']>0)
                                <tr>
                                    <td colspan="4">Uygulanan İndirim: </td>
                                    <td colspan="1" class="bg-danger text-white">-{{ number_format($order['kupon_price'])}}₺</td>
                                </tr>
                                <tr>
                                    <td colspan="4">Sipariş Toplam Tutar: </td>
                                    <td colspan="1" class="bg-success text-white">{{ number_format(($totalPrice - $order['kupon_price']),2)}}₺</td>
                                </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>

                    <div class="form-group">
                        <label for="durum">Durum</label>
                        @error('status')
                            <span class="text-danger">{{ $messages }}</span>
                        @enderror
                        @php
                            $statu = $invoice->status ?? '1';
                        @endphp
                        <select class="form-control" id="durum" name="status">
                            <option value="1" {{ $statu == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $statu == '0' ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    <a href="{{ route('panel.order.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>

@endsection
