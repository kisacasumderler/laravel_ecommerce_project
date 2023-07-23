@extends('backend.layout.app')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Sipariş Detay
                </h4>
        <div class="d-flex flex-row justify-content-end align-items-end p-1">
            <a href="{{ route('panel.generate.pdf', $order->id) }}"
                class="btn btn-success">Fatura Görüntüle</a>
        </div>
                <form action="{{ route('panel.order.update', $order->id) }}" class="forms-sample" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (!empty($order->id))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="order_no">Sipariş Kodu</label>
                        <input type="text" class="form-control" id="order_no" value="{{ DonusumleriGeriDondur($order->order_no) ?? '' }}"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="c_name">İsim Soyisim</label>
                        <input type="text" class="form-control" id="c_name" value="{{ DonusumleriGeriDondur($order->c_name) ?? '' }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="c_email_address">Email Adres</label>
                        <input type="c_email_address" class="form-control" id="c_email_address" value="{{ DonusumleriGeriDondur($order->c_email_address) ?? '' }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="c_phone">Telefon Numarası</label>
                        <input type="text" class="form-control" id="c_phone" value="{{ $order->c_phone ?? '' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="c_companyname">Şirket Adı</label>
                        <input type="text" class="form-control" id="c_companyname" value="{{ $order->c_companyname ?? '' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="c_country">Ülke</label>
                        <input type="text" class="form-control" id="c_country" value="{{ $order->c_country ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="c_city">Şehir</label>
                        <input type="text" class="form-control" id="c_city" value="{{ $order->c_city ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="c_state_country">Sokak</label>
                        <input type="text" class="form-control" id="c_state_country" value="{{ $order->c_state_country ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="c_address">Adres Bilgisi</label>
                        <input type="text" class="form-control" id="c_address" value="{{ $order->c_address ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="c_postal_zip">Posta Kodu</label>
                        <input type="text" class="form-control" id="c_postal_zip" value="{{ $order->c_postal_zip ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="order_note">Sipariş Notu</label>
                        <textarea type="text" class="form-control" id="order_note" rows="5" readonly>{{ DonusumleriGeriDondur($order->order_note) ?? '' }} </textarea>
                    </div>
                    <div class="form-group">
                        <label for="durum">Durum</label>
                        @php
                            $statu = $order->status ?? '1';
                        @endphp
                        <select class="form-control" id="durum" name="status">
                            <option value="1" {{ $statu == '1' ? 'selected' : '' }}>Sipariş Onaylandı</option>
                            <option value="0" {{ $statu == '0' ? 'selected' : '' }}>Sipariş Geldi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    <a href="{{ route('panel.order.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script>
        @if (session()->get('success'))
            alertify.success('{{ session()->get("success") }}');
        @endif
        @if ($errors)
            @foreach ($errors->all() as $error)
                alertify.error('{{ $error }}')
            @endforeach
        @endif
    </script>
@endsection
