@if (!empty($products) && $products->count() > 0)
    @foreach ($products as $product)
        @php
            $arrImage = collect($product->images->data ?? '')->sortByDesc('vitrin');
            $images = $arrImage->first()['image'] ?? 'images/resimyok.jpg';
            $alt = $arrImage->first()['alt'] ?? 'productImage';
        @endphp

        @if (!empty($discounts) && $discounts->count() > 0)
            @php
                $newPrice = disocuntControl($discounts, $product);
            @endphp
        @endif
        <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
            <div class="block-4 text-center border ">
                <figure class="block-4-image">
                    <a href="{{ route('urundetay', $product->slug) }}"><img
                            src="{{ asset($images ?? 'images/resimyok.jpg') }}" alt="{{ $alt }}"
                            class="img-fluid"></a>
                </figure>
                <div class="block-4-text p-4">
                    <h3><a href="{{ route('urundetay', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    <p class="mb-0">{{ $product->short_text }}</p>
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
                    <p><a href="{{ route('urundetay', $product->slug) }}" class="buy-now btn btn-sm btn-primary">Ürün
                            Detay</a></p>
                </div>
            </div>
        </div>
    @endforeach
@endif
