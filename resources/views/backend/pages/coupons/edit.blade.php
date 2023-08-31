@extends('backend.layout.app')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @if (!empty($coupon->id))
                        Kupon Güncelle
                    @else
                        Kupon Ekle
                    @endif
                </h4>
                <p class="card-description">
                    Kupon Ekleme Formu
                </p>
                @php
                    if (!empty($coupon->id)) {
                        $routeLink = route('panel.coupons.update', $coupon->id);
                    } else {
                        $routeLink = route('panel.coupons.store');
                    }
                @endphp
                <form action="{{ $routeLink }}" class="forms-sample" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($coupon->id))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="name">Kupon Kodu</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $coupon->name ?? old('name') }}" placeholder="Kupon Kodu">
                    </div>
                    <div class="form-group">
                        <label for="price">İndirim Tutarı</label>
                        <input type="text" class="form-control" id="price" name="price"
                            value="{{ $coupon->price ?? old('price') }}" placeholder="İndirim Tutarı">
                    </div>
                    <div class="form-group">
                        <label for="discount_rate">İndirim Oranı</label>
                        <input type="text" class="form-control" id="discount_rate" name="discount_rate"
                            value="{{ $coupon->discount_rate ?? old('discount_rate') }}" placeholder="İndirim Oranı">
                    </div>
                    @if (!empty($categories))
                    @php
                        $couponCatId = $coupon->category_id ?? '0';
                    @endphp
                        <div class="form-group">
                            <label for="category">İndirim Uygulanacak Ürünler</label>
                            <select name="category" id="category" class="form-control">
                                <option value="0">Tüm Ürünler</option>
                                {{ recursiveCategoryPrintWithParent($categories) }}
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="durum">Kupon Türü</label>
                        @php
                            $isDiscount = $coupon->isDiscount ?? '1';
                        @endphp
                        <select class="form-control" id="durum" name="isDiscount">
                            <option value="1" {{ $isDiscount == '1' ? 'selected' : '' }}>Ürün İndirim</option>
                            <option value="0" {{ $isDiscount == '0' ? 'selected' : '' }}>Kupon Kodu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="durum">Durum</label>
                        @php
                            $statu = $coupon->status ?? '1';
                        @endphp
                        <select class="form-control" id="durum" name="status">
                            <option value="1" {{ $statu == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $statu == '0' ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    <a href="{{ route('panel.coupons.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
