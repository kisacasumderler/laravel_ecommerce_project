@extends('frontend.layout.layout')
@section('content')
@include('backend.inc.Breadcrumb')
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-9 order-2">

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="float-md-left mb-4">
                                <h2 class="text-black h5">Tüm Ürünler</h2>
                            </div>
                            <div class="d-flex">
                                <div class="dropdown mr-1 ml-md-auto">
                                    <div class="btn-group">
                                        <select id="orderList" class="form-control">
                                            <option class="dropdown-item" value="">Sırala
                                            </option>
                                            <option class="dropdown-item" value="name-asc" data-sira="a_z_order">İsim: A'dan
                                                Z'ye</option>
                                            <option class="dropdown-item" value="name-desc" data-sira="z_a_order">İsim:
                                                Z'den
                                                A'ya</option>
                                            <div class="dropdown-divider"></div>
                                            <option class="dropdown-item" value="price-asc" data-sira="price_min_order">
                                                Fiyat:
                                                Düşükten yükseğe</option>
                                            <option class="dropdown-item" value="price-desc" data-sira="price_max_order">
                                                Fiyat:
                                                Yüksekten Düşüğe</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5 products_content ">
                        @include('frontend.ajax.productList')
                    </div>
                    <div class="row paginateButtons">{{ $products->withQueryString()->links('pagination::bootstrap-4') }}
                    </div>
                </div>

                <div class="col-md-3 order-1 mb-5 mb-md-0">
                    <div class="border p-4 rounded mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Kategori</h3>
                        <ul class="list-unstyled mb-0">
                            @if (!empty($categories) && $categories->count() > 0)
                                @foreach ($categories->where('cat_ust', null) as $category)
                                    <li class="mb-1"><a href="{{ route($category->slug . 'urunler') }}"
                                            class="d-flex"><span>{{ $category->name }}</span> <span
                                                class="text-black ml-auto">({{ $category->getTotalProductCount() }})</span></a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="border p-4 rounded mb-4">
                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Fiyata göre filtrele</h3>
                            <div id="slider-range" class="border-primary"></div>
                            <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white"
                                disabled="" />
                            <input type="hidden" id="priceBetween">
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Boyut</h3>
                            @if (!empty($sizeLists))
                                @foreach ($sizeLists as $key => $size)
                                    <label for="size{{ $key }}" class="d-flex">
                                        <input type="checkbox" id="size{{ $key }}" class="mr-2 mt-1 sizeList"
                                            {{ isset(request()->size) && in_array($size, explode(',', request()->size)) ? 'checked' : '' }}
                                            value="{{ $size }}">
                                        <span class="text-black"> {{ $size }} </span>
                                    </label>
                                @endforeach
                            @endif
                        </div>
                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Renk</h3>
                            @if (!empty($colors))
                                @foreach ($colors as $key => $color)
                                    <label href="#" class="d-flex color-item align-items-center">
                                        <input type="checkbox" id="color{{ $key }}"
                                            class="color d-inline-block rounded-circle mr-2 colorList"
                                            {{ isset(request()->color) && in_array($color, explode(',', request()->color)) ? 'checked' : '' }}
                                            value={{ $color }}><span class="text-black"> {{ $color }}
                                        </span>
                                    </label>
                                @endforeach
                            @endif
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-primary btn-block filter_btn">Filtrele</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="site-section site-blocks-2">
                        <div class="row justify-content-center text-center mb-5">
                            <div class="col-md-7 site-section-heading pt-4">
                                <h2>Kategori</h2>
                            </div>
                        </div>
                        <div class="row">
                            @if (!empty($categories) && $categories->count() > 0)
                                @foreach ($categories->where('cat_ust', null) as $category)
                                @php
                                    $categoryImage = collect($category->images->data ?? '')
                                @endphp
                                    <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                                        <a class="block-2-item" href="{{ route($category->slug . 'urunler') }}">
                                            <figure class="image">
                                                <img src="{{  asset($categoryImage->sortByDesc('vitrin')->first()['image'] ?? 'images/resimyok.jpg') }}" alt="" class="img-fluid">
                                            </figure>
                                            <div class="text">
                                                <span class="text-uppercase">Giyim</span>
                                                <h3>{{ $category->name }}</h3>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('customjs')
    <script>
        var maxprice = "{{ $maxprice }}",
            defaultminprice = {{ request()->min ?? 0 }},
            defaultmaxprice = {{ request()->max ?? $maxprice }};

        var url = new URL(window.location.href);

        $(document).ready(function() {
            $(document).on('click', '.filter_btn', function(e) {
                filtrele();
            });

            function filtrele() {
                let colorList = $('.colorList:checked').map((_, chk) => chk.value).get();
                let sizeList = $('.sizeList:checked').map((_, chk) => chk.value).get();
                if (colorList.length > 0) {
                    url.searchParams.set("color", colorList.join(","));
                } else {
                    url.searchParams.delete('color');
                }
                if (sizeList.length > 0) {
                    url.searchParams.set("size", sizeList.join(","));
                } else {
                    url.searchParams.delete('size');
                }

                var price = $('#priceBetween').val().split('-');
                url.searchParams.set("min", price[0])
                url.searchParams.set("max", price[1])

                newUrl = url.href;
                window.history.pushState({}, '', newUrl);
                // location.reload();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    url: newUrl,
                    success: function(response) {
                        $('.products_content').html(response.data);
                        $('.paginateButtons').html(response.paginate);
                    }
                })
            }


            $(document).on('change', '#orderList', function(e) {
                var order = $(this).val();

                if (order != '') {
                    orderBy = order.split('-');
                    url.searchParams.set("order", orderBy[0])
                    url.searchParams.set("sort", orderBy[1])
                } else {
                    url.searchParams.delete('order');
                    url.searchParams.delete('sort');
                }
                filtrele();
            });
        });



        //products_content, paginateButtons,
    </script>
@endsection
