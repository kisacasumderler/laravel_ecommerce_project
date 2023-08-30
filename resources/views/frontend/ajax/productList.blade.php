@if (!empty($products) && $products->count() > 0)
@foreach ($products as $product)
@php
$arrImage = collect($product->images->data ?? '')
        ->sortByDesc('vitrin');
$images = $arrImage->first()['image'] ?? 'images/resimyok.jpg';
$alt = $arrImage->first()['alt'] ?? 'productImage';
@endphp
    <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
        <div class="block-4 text-center border ">
            <figure class="block-4-image">
                <a href="{{ route('urundetay', $product->slug) }}"><img
                        src="{{asset($images ?? 'images/resimyok.jpg')}}" alt="{{$alt}}"
                        class="img-fluid"></a>
            </figure>
            <div class="block-4-text p-4">
                <h3><a href="{{ route('urundetay', $product->slug) }}">{{ $product->name }}</a>
                </h3>
                <p class="mb-0">{{ $product->short_text }}</p>
                <p class="text-primary font-weight-bold">
                    {{ number_format($product->price, 2) }}₺
                </p>
                <p><a href="{{ route('urundetay', $product->slug) }}"
                        class="buy-now btn btn-sm btn-primary">Ürün Detay</a></p>
            </div>
        </div>
    </div>
@endforeach
@endif
