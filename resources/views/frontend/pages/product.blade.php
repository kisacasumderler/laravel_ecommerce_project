@extends('frontend.layout.layout')
@section('content')
    @include('backend.inc.Breadcrumb')

    @php
        $image =
            collect($product->images->data ?? '')
                ->sortByDesc('vitrin')
                ->first()['image'] ?? 'images/resimyok.jpg';
    @endphp
    @if (!empty($discounts) && $discounts->count() > 0)
        @php
            $newPrice = disocuntControl($discounts, $product);
        @endphp
    @endif
    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset($image ?? 'images/resimyok.jpg') }}" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2 class="text-black">{{ $product->name ?? '' }}</h2>
                    {!! $product->content !!}
                    @if (isset($newPrice['discountRate']) && $newPrice['discountRate'] > 0)
                        <p class="mt-2">
                            <span class="bg-danger text-white p-1 rounded">
                                % {{ $newPrice['discountRate'] }} İndirimli Ürün
                            </span>
                        </p>
                    @endif
                    <p>
                        @if (isset($newPrice['price']))
                            @if ($newPrice['price'] != $product->price)
                                <span style="text-decoration: line-through">
                                    {{ number_format($product->price, 2) }}₺</span>
                                <strong class="text-primary h4">{{ number_format($newPrice['price'], 2) }}₺</strong>
                            @else
                                <strong class="text-primary h4">{{ number_format($product->price, 2) }}₺</strong>
                            @endif
                        @else
                            <strong class="text-primary h4">{{ number_format($product->price, 2) }}₺</strong>
                        @endif
                    </p>
                    <form action="{{ route('sepet.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="urunImg" value="{{ $image ?? 'images/resimyok.jpg' }}">
                        <div class="mb-1 d-flex">
                            <label for="product{{ $product->id }}" class="d-flex mr-3 mb-3">
                                <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input
                                        type="radio" id="product{{ $product->id }}" name="size"
                                        value="{{ $product->size }}" checked></span> <span
                                    class="d-inline-block text-black">{{ $product->size }}</span>
                            </label>
                        </div>
                        <div class="mb-5">
                            <div class="input-group mb-3" style="max-width: 120px;">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                                </div>
                                <input type="text" class="form-control text-center" value="1" name="qty"
                                    placeholder="" aria-label="Example text with button addon"
                                    aria-describedby="button-addon1">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                                </div>
                            </div>
                        </div>
                        <p><button class="buy-now btn btn-sm btn-primary">Sepete Ekle</button></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (!empty($Products) && $Products->count() > 0)
        <div class="site-section block-3 site-blocks-2 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-7 site-section-heading text-center pt-4">
                        <h2>Benzer Ürünler</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="nonloop-block-3 owl-carousel">
                            @foreach ($Products as $product)
                                @php
                                    $images =
                                        collect($product->images->data ?? '')
                                            ->sortByDesc('vitrin')
                                            ->first()['image'] ?? 'images/resimyok.jpg';
                                @endphp
                                @if (!empty($discounts) && $discounts->count() > 0)
                                    @php
                                        $spNewPrice = disocuntControl($discounts, $product);
                                    @endphp
                                @endif
                                <div class="item">
                                    <div class="block-4 text-center">
                                        <figure class="block-4-image">
                                            <img src="{{ asset($images ?? 'images/resimyok.jpg') }}"
                                                alt="Image placeholder" class="img-fluid">
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3><a
                                                    href="{{ route('urundetay', $product->slug) }}">{{ $product->name }}</a>
                                            </h3>
                                            <p class="mb-0">{{ $product->short_text }}</p>
                                            @if (isset($spNewPrice['discountRate']) && $spNewPrice['discountRate'] > 0)
                                                <p class="mt-2">
                                                    <span class="bg-danger text-white p-1 rounded">
                                                        % {{ $spNewPrice['discountRate'] }} İndirimli Ürün
                                                    </span>
                                                </p>
                                            @endif
                                            <p>
                                                @if (isset($spNewPrice['price']))
                                                    @if ($spNewPrice['price'] != $product->price)
                                                        <span style="text-decoration: line-through">
                                                            {{ number_format($product->price, 2) }}₺</span>
                                                        <strong
                                                            class="text-primary h4">{{ number_format($spNewPrice['price'], 2) }}₺</strong>
                                                    @else
                                                        <strong
                                                            class="text-primary h4">{{ number_format($product->price, 2) }}₺</strong>
                                                    @endif
                                                @else
                                                    <strong
                                                        class="text-primary h4">{{ number_format($product->price, 2) }}₺</strong>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('customjs')
    <script>
        @if (session()->get('success'))
            alertify.success('{{ session()->get('success') }}');
        @endif
    </script>
@endsection
