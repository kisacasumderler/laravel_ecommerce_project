@extends('frontend.layout.layout')
@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="{{ route('anasayfa') }}">Anasayfa</a> <span class="mx-2 mb-0">/</span>
                    <strong class="text-black">{{ $product->name ?? '' }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset($product->image ?? 'images/cloth_1.jpg') }}" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2 class="text-black">{{ $product->name ?? '' }}</h2>
                    {!! $product->content !!}
                    <p><strong class="text-primary h4">{{ number_format($product->price, 2) }}₺</strong></p>
                    <form action="{{ route('sepet.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                                <div class="item">
                                    <div class="block-4 text-center">
                                        <figure class="block-4-image">
                                            <img src="{{ asset($product->image) }}" alt="Image placeholder"
                                                class="img-fluid">
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3><a
                                                    href="{{ route('urundetay', $product->slug) }}">{{ $product->name }}</a>
                                            </h3>
                                            <p class="mb-0">{{ $product->short_text }}</p>
                                            <p class="text-primary font-weight-bold">
                                                {{ number_format($product->price, 2) }}₺</p>
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
            alertify.success('{{ session()->get("success") }}');
        @endif
    </script>
@endsection
