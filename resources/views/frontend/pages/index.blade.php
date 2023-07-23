@extends('frontend.layout.layout')
@section('content')
    @if (!empty($sliders) && $sliders->count() > 0)
        <div id="carouselId" class="carousel slide w-100" data-ride="carousel">
            <ol class="carousel-indicators">
                @for ($i = 0; $i < $sliders->count(); $i++)
                    <li data-target="#carouselId" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}">
                    </li>
                @endfor
            </ol>
            <div class="carousel-inner">
                @foreach ($sliders as $slider)
                    @if ($loop->first)
                        <div class="carousel-item active mb-2" style="position: relative;">
                            @isset($slider->image)
                            @else
                                <div class="carousel-caption sliderText desktopEle">
                                    <h3>{{ $slider->name }}</h3>
                                    <p>{{ $slider->content }}</p>
                                    <a href="{{ route('urunler') }}" class="btn btn-primary">Alışverişe Başla</a>
                                </div>
                            @endisset
                            @isset($slider->MobileImage)
                            @else
                                <div class="carousel-caption sliderText mobileEle">
                                    <h3>{{ $slider->name }}</h3>
                                    <p>{{ $slider->content }}</p>
                                    <a href="{{ route('urunler') }}" class="btn btn-primary">Alışverişe Başla</a>
                                </div>
                            @endisset

                            <a href="{{ route($slider->link ?? 'urunler') }}" class="d-block ImgCapa">
                                <img src="{{ asset($slider->image ?? 'images/sliderbg.jpg') }}" alt="..."
                                    class="ImageDesk">
                                <img src="{{ asset($slider->MobileImage ?? 'images/mobile_sliderbg.jpg') }}" alt=""
                                    class="ImageMobile">
                            </a>
                        </div>
                    @else
                        <div class="carousel-item mb-2" style="position: relative;">
                            @isset($slider->image)
                            @else
                                <div class="carousel-caption sliderText desktopEle">
                                    <h3>{{ $slider->name }}</h3>
                                    <p>{{ $slider->content }}</p>
                                    <a href="{{ route('urunler') }}" class="btn btn-primary">Alışverişe Başla</a>
                                </div>
                            @endisset
                            @isset($slider->MobileImage)
                            @else
                                <div class="carousel-caption sliderText mobileEle">
                                    <h3>{{ $slider->name }}</h3>
                                    <p>{{ $slider->content }}</p>
                                    <a href="{{ route('urunler') }}" class="btn btn-primary">Alışverişe Başla</a>
                                </div>
                            @endisset
                            <a href="{{ route($slider->link ?? 'urunler') }}" class="d-block ImgCapa">
                                <img src="{{ asset($slider->image ?? 'images/sliderbg.jpg') }}" alt="..."
                                    class="ImageDesk">
                                <img src="{{ asset($slider->MobileImage ?? 'images/mobile_sliderbg.jpg') }}" alt=""
                                    class="ImageMobile">
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

            <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    @endif
    <div class="site-section site-section-sm site-blocks-1 border-0" data-aos="fade">
        <div class="container">
            <div class="row">
                @for ($i = 1; $i < 4; $i++)
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
                        <div class="icon mr-4 align-self-start">
                            <span class="{{ DonusumleriGeriDondur($about->{'text_' . $i . '_icon'}) }}"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase">{{DonusumleriGeriDondur( $about->{'text_' . $i}) }}</h2>
                            <p>
                                {{ DonusumleriGeriDondur($about->{'text_' . $i . '_content'}) }}
                            </p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="site-section site-blocks-2">
            <div class="container">
                <div class="row">
                    @if (!empty($categories) && $categories->count() > 0)
                        @foreach ($categories->where('cat_ust', null) as $category)
                            <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                                <a class="block-2-item" href="{{ route($category->slug . 'urunler') }}">
                                    <figure class="image">
                                        <img src="{{ asset($category->image) }}" alt="" class="img-fluid">
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

        @if (!empty($categories) && $categories->count() > 0)
            <div class="site-section block-3 site-blocks-2">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-7 site-section-heading text-center pt-4">
                            <h2>Diğer Kategoriler ve Kampanyalar</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nonloop-block-3 owl-carousel">
                                @foreach ($categories->where('cat_ust', null)->where('status', '1') as $category)
                                    @foreach ($category->subCategory->where('status', '1') as $alt_category)
                                        @isset($alt_category->image)
                                            <div class="item">
                                                <div class="block-4 text-center bg-light">
                                                    <figure class="block-4-image">
                                                        <a
                                                            href="{{ route($category->slug . 'urunler', $alt_category->slug) }}">
                                                            <img src="{{ asset($alt_category->image) }}"
                                                                alt="Image placeholder" class="img-fluid"></a>
                                                    </figure>
                                                </div>
                                            </div>
                                        @endisset
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (!empty($newProducts) && $newProducts->count() > 0)
            <div class="site-section block-3 site-blocks-2 bg-light">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-7 site-section-heading text-center pt-4">
                            <h2>Yeni Eklenen Ürünler</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nonloop-block-3 owl-carousel">
                                @foreach ($newProducts as $Product)
                                    <div class="item">
                                        <div class="block-4 text-center">
                                            <figure class="block-4-image">
                                                <img src="{{ asset($Product->image) }}" alt="Image placeholder"
                                                    class="img-fluid">
                                            </figure>
                                            <div class="block-4-text p-4">
                                                <h3><a
                                                        href="{{ route('urundetay', $Product->slug) }}">{{ $Product->name }}</a>
                                                </h3>
                                                <p class="mb-0">{{ $Product->short_text }}</p>
                                                <p class="text-primary font-weight-bold">
                                                    {{ number_format($Product->price, 2) }}₺</p>
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
        @if (!empty($specialOffer) && $specialOffer->count() > 0)
            <div class="site-section block-8">
                <div class="container">
                    <div class="row justify-content-center  mb-5">
                        <div class="col-md-7 site-section-heading text-center pt-4">
                            <h2>  {{$specialOffer->name}}</h2>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-12 col-lg-7 mb-5">
                            <a href="#"><img src="{{$specialOffer->image}}" alt="Image placeholder"
                                    class="img-fluid rounded"></a>
                        </div>
                        <div class="col-md-12 col-lg-5 text-center pl-md-5">
                            <h2><a href="#">{{$specialOffer->title}}</a></h2>
                            <p>{!!$specialOffer->message!!}</p>
                            <p><a href="{{ route($specialOffer->link) }}" class="btn btn-primary btn-sm">Ürünler</a></p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @endsection
