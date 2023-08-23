@extends('frontend.layout.layout')
@section('content')
@include('backend.inc.Breadcrumb')
    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="h3 mb-3 text-black">İletişim Formu</h2>
                </div>
                <div class="col-md-7">

                    <form action="{{ route('iletisim.kaydet') }}" method="post">
                        @csrf
                        <div class="p-3 p-lg-5 border">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="name" class="text-black">Ad Soyad <span
                                            class="text-danger">*</span></label>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="email" class="text-black">Eposta <span class="text-danger">*</span></label>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <input type="email" class="form-control" id="c_email" name="email" placeholder=""
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="subject" class="text-black">Başlık <span class="text-danger">*</span></label>
                                    @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <input type="text" class="form-control" id="subject" name="subject"
                                        value="{{ old('subject') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="message" class="text-black">Mesaj <span class="text-danger">*</span> </label>
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <textarea name="message" id="message" cols="30" rows="7" class="form-control">{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button class="btn btn-primary btn-lg btn-block">Gönder</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-5 ml-auto">
                    <div class="p-4 border mb-3">
                        <span class="d-block text-primary h6 text-uppercase">Telefon</span>
                        <p class="mb-0">{{ $settings['phone'] }}</p>
                    </div>
                    <div class="p-4 border mb-3">
                        <span class="d-block text-primary h6 text-uppercase">Email</span>
                        <p class="mb-0">{{ $settings['email'] }}</p>
                    </div>
                    <div class="p-4 border mb-3">
                        <span class="d-block text-primary h6 text-uppercase">Adres</span>
                        <p class="mb-0">{!! $settings['address'] !!}</p>
                    </div>
                    <div class="p-4 border mb-3">
                        <iframe src="https://www.google.com/maps/embed?pb={{ urlencode($settings['address']) }}"
                            style="border:0; width:100%; min-height: 300px" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
