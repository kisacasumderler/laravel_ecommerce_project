@php
    use Carbon\Carbon;
@endphp
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
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="5">
                <table>
                    <tr>
                        <td class="title">
                            <img src="{{ asset($companyLogo) }}" style="width:100%; max-width:300px;"
                                class="img-fluid">
                        </td>
                        <td>
                            <span style="font-size: 1.3rem;" class="text-danger">
                                Sipariş Kodu : {{ DonusumleriGeriDondur($invoice->order_no) ?? '' }}
                            </span>
                            <br>
                            <strong>
                                Sipriş Tarihi:
                                {{ isset($invoice->created_at) ? Carbon::parse($invoice->created_at)->format('d.m.Y H:i') : '' }}
                            </strong>
                            <br>
                            <strong>
                                Güncelleme Tarihi:
                                {{ isset($invoice->updated_at) ? Carbon::parse($invoice->updated_at)->format('d.m.Y H:i') : '' }}
                            </strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="5">
                <table>
                    <tr>
                        <td>
                            <b>Şirket bilgileri: </b> <br>
                            {!! str_replace(',', '<br>', Guvenlik($companyAddress)) !!} / {{ config('app.name') }}
                        </td>

                        <td>
                            <b>Kullanıcı Bilgileri:</b> <br>
                            {!! $invoice->c_name ? $invoice->c_name . '<br>' : '' !!}
                            {!! $invoice->c_phone ? $invoice->c_phone . '<br>' : '' !!}
                            {!! $invoice->c_email_address ? $invoice->c_email_address . '<br><br>' : '' !!}
                            {!! $invoice->c_address ? $invoice->c_address . '<br>' : '' !!}
                            {!! $invoice->c_state_country ? $invoice->c_state_country . '<br>' : '' !!}
                            {!! $invoice->c_country ? $invoice->c_country . '<br>' : '' !!}
                            {!! $invoice->c_postal_zip ? $invoice->c_postal_zip . '<br>' : '' !!}
                            {!! $invoice->c_companyname ? $invoice->c_companyname . '<br>' : '' !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td colspan="5">Ödeme Yöntemi</td>
        </tr>

        <tr class="details">
            <td colspan="5">Nakit</td>
        </tr>

        <tr class="heading">
            <td>Ürün Adı</td>
            <td>Fiyat</td>
            <td>adet</td>
            <td>KDV</td>
            <td>Toplam</td>
        </tr>

        @php
            $totalPrice = 0;
        @endphp
        @if (!empty($invoice->orders) && $invoice->orders->count() > 0)
            @foreach ($invoice->orders as $order)
                <tr class="item" v-for="item in items">
                    <td>{{ $order['name'] }}</td>
                    <td>{{ $order['price'] }}</td>
                    <td>{{ $order['qty'] }}</td>
                    <td>{{ number_format(($order['kdv'] *  $order['qty']),2) }}₺</td>
                    <td>{{ number_format(($order['price'] *  $order['qty']) + ($order['kdv'] *  $order['qty']),2) }}₺</td>
                </tr>
                @php
                    $totalPrice += ($order['price'] *  $order['qty']) + ($order['kdv'] *  $order['qty']);
                @endphp
            @endforeach
        @endif

        <tr class="total">
            <td colspan="4"></td>
            <td>Toplam Tutar: {{number_format($totalPrice,2)}}₺</td>
        </tr>
    </table>
</div>
