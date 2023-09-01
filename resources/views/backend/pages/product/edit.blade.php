@extends('backend.layout.app')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @if (!empty($product->id))
                    <h4>Ürün Güncelle</h4>
                    <p>Ürün Bilgileri Güncelleme Formu</p>
                @else
                    <h4>Ürün Ekle</h4>
                    <p>Ürün Ekleme Formu</p>
                @endif
                @php
                    if (!empty($product->id)) {
                        $routeLink = route('panel.product.update', $product->id);
                    } else {
                        $routeLink = route('panel.product.store');
                    }
                @endphp
                <form action="{{ $routeLink }}" class="forms-sample" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($product->id))
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="name">İsim</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $product->name ?? '' }}" placeholder="İsim">
                    </div>
                    <div class="row">
                        <div class="col-4 form-group">
                            <label for="fiyat">Fiyat</label>
                            <input type="text" class="form-control" placeholder="kdv hariç fiyatı buraya yazınız."
                                value="{{ $product->tax_free_price ?? '' }}" id="fiyat" name="tax_free_price">
                        </div>
                        <div class="col-4 form-group">
                            <label for="kdv">Kdv Oranı (%)</label>
                            <input type="text" class="form-control" id="kdv" name="kdv"
                                value="{{ $product->kdv ?? '' }}" placeholder="Kdv Oranını buraya yazınız">
                        </div>
                        <div class="col-4 form-group">
                            <label for="price">Kdv Dahil Fiyat</label>
                            <input type="text" class="form-control" id="price" value="{{ $product->price ?? '' }}"
                                placeholder="Kdv Dahil Toplam fiyat" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="qty">Adet</label>
                        <input type="number" class="form-control" id="qty" name="qty"
                            value="{{ $product->qty ?? '' }}" placeholder="Ürün Adet">
                    </div>
                    <div class="form-group">
                        <label for="size">Boyut</label>
                        <select name="size" id="size" class="form-control">
                            <option value="">Beden Seçiniz</option>
                            <option value="XS" {{ isset($product->size) && $product->size == 'XS' ? 'selected' : '' }}>
                                XS</option>
                            <option value="S" {{ isset($product->size) && $product->size == 'S' ? 'selected' : '' }}>S
                            </option>
                            <option value="M" {{ isset($product->size) && $product->size == 'M' ? 'selected' : '' }}>M
                            </option>
                            <option value="L" {{ isset($product->size) && $product->size == 'L' ? 'selected' : '' }}>L
                            </option>
                            <option value="XL" {{ isset($product->size) && $product->size == 'XL' ? 'selected' : '' }}>
                                XL</option>
                            <option value="XXL"
                                {{ isset($product->size) && $product->size == 'XXL' ? 'selected' : '' }}>
                                XXL</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="color">Renk</label>
                        <input type="text" class="form-control" id="color" name="color"
                            value="{{ $product->color ?? '' }}" placeholder="Kategori adı">
                    </div>
                    <div class="form-group">
                        @if (!empty($categories))
                            @php
                                $couponCatId = $coupon->category_id ?? null;
                            @endphp
                            <div class="form-group">
                                <label for="category">ürün Kategori</label>
                                <select name="category" id="category" class="form-control">
                                    {{ recursiveCategoryPrintWithParent($categories, [], $couponCatId) }}
                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="short_text">Kısa Bilgi</label>
                        <textarea name="short_text" id="short_text" class="form-control">{{ $product->short_text ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="icerik">Açıklama</label>
                        <textarea name="content" id="icerik" cols="30" rows="10" class="form-control ckeditor">{{ $product->content ?? '' }}</textarea>
                    </div>
                    <div class="form-row align-items-end">
                        <div class="col">
                            <div class="col-lg-12 d-flex images">
                                @if (isset($product) && !empty($product->images->data))
                                    @php
                                        $images = collect($product->images->data ?? '');
                                    @endphp
                                    @foreach ($images->sortByDesc('vitrin') as $item)
                                        <div class="item mx-4" data-id="{{ $product->id }}" data-model="Product"
                                            data-image_no="{{ $item['image_no'] }}">
                                            <img src="{{ asset($item['image']) }}" class="img-thumbnail">
                                            <button type="button"
                                                class="deleteImage btn btn-sm btn-danger btn btn-sm btn-danger d-flex align-items-center px-2 mt-3">X</button>
                                            <div class="mt-4">
                                                <label class="d-block">
                                                    <input class="radio_animated vitrinBtn" type="radio"
                                                        {{ $item['vitrin'] == 1 ? 'checked' : '' }}>Vitrin Yap
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="form-group">
                                <label>File upload</label>
                                <input type="file" name="image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Resim Yükle" value="{{ $product->image ?? '' }}">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Yükle</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="durum">Durum</label>
                        @php
                            $statu = $product->status ?? '1';
                        @endphp
                        <select class="form-control" id="durum" name="status">
                            <option value="1" {{ $statu == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $statu == '0' ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    <a href="{{ route('panel.product.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script src="{{ asset('backend/js/cdn.ckeditor.com_ckeditor5_38.1.0_classic_ckeditor.js') }}"></script>
    <script src="{{ asset('backend/js/cdn.ckeditor.com_ckeditor5_38.1.0_classic_translations_tr.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('.ckeditor'), {
                language: 'tr',
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6'
                        }
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });


        $('#fiyat, #kdv').on('input', function() {
            let fiyat = parseFloat($('#fiyat').val());
            let kdv = parseFloat($('#kdv').val());

            if (isNaN(fiyat) || isNaN(kdv)) {
                $('#price').val('');
                return;
            }

            let newPrice = fiyat + (fiyat * (kdv / 100));
            $('#price').val(newPrice.toFixed(2));
        });
    </script>
@endsection
