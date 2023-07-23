@extends('frontend.layout.layout')
@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong
                        class="text-black">About</strong></div>
            </div>
        </div>
    </div>

    <div class="site-section border-bottom" data-aos="fade">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="block-16">
                        <figure>
                            <img src="{{ asset($about->image) }}" alt="Image placeholder" class="img-fluid rounded">
                            <a href="https://vimeo.com/channels/staffpicks/93951774" class="play-button popup-vimeo"><span
                                    class="ion-md-play"></span></a>

                        </figure>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="site-section-heading pt-3 mb-4">
                        <h2 class="text-black">{{ $about->name }}</h2>
                    </div>
                    {!! htmlspecialchars_decode($about->content) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="site-section site-section-sm site-blocks-1 border-0" data-aos="fade">
        <div class="container">
            <div class="row">
                @for ($i = 1; $i < 4; $i++)
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
                        <div class="icon mr-4 align-self-start">
                            <span class="{{ DonusumleriGeriDondur($about->{'text_' . $i . '_icon'}) }}"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase">{{ DonusumleriGeriDondur($about->{'text_' . $i}) }}</h2>
                            <p>
                                {{ DonusumleriGeriDondur($about->{'text_' . $i . '_content'}) }}
                            </p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection
