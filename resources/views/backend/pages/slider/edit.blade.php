@extends('backend.layout.app')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @if (!empty($slider->id))
                        Slider Güncelle
                    @else
                        Slider Ekle
                    @endif
                </h4>
                <p class="card-description">
                    Slider Ekleme Formu
                </p>
                @php
                    if (!empty($slider->id)) {
                        $routeLink = route('panel.slider.update', $slider->id);
                    } else {
                        $routeLink = route('panel.slider.store');
                    }
                @endphp
                <form action="{{ $routeLink }}" class="forms-sample" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($slider->id))
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="name">Başlık</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $slider->name ?? old('name') }}" placeholder="Slider Başlık">
                    </div>
                    <div class="form-group">
                        <label for="icerik">İçerik</label>
                        <textarea type="text" class="form-control" id="icerik" name="content">{{ old('content') ?? ($slider->content ?? '') }} </textarea>
                    </div>
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" class="form-control" id="link" placeholder="Slider linki" name="link"
                            value="{{ old('link') ?? ($slider->link ?? '') }}">
                    </div>
                    <div class="form-row align-items-end">
                        <div class="col">
                            <div class="col-lg-12 d-flex images">
                                @if (isset($slider) && !empty($slider->images->data))
                                    @php
                                        $images = collect($slider->images->data ?? '');
                                    @endphp
                                    @foreach ($images->sortByDesc('vitrin') as $item)
                                        <div class="item mx-4" data-id="{{ $slider->id }}" data-model="Slider"
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
                                        placeholder="Resim Yükle" value="{{ old('image') ?? ($slider->image ?? '') }}">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Yükle</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            {{-- sliderMobile --}}
                            <div class="col-lg-12 d-flex images">
                                @if (isset($sliderMobile) && !empty($sliderMobile->images->data))
                                    @php
                                        $images = collect($sliderMobile->images->data ?? '');
                                    @endphp
                                    @foreach ($images->sortByDesc('vitrin') as $item)
                                        <div class="item mx-4" data-id="{{ $sliderMobile->id }}" data-model="SliderMobile"
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
                                    <input type="file" name="MobileImage" class="file-upload-default">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled
                                            placeholder="Mobil Versiyon Resim Yükle"
                                            value="{{ old('MobileImage') ?? ($slider->MobileImage ?? '') }}">
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
                                $statu = $slider->status ?? '1';
                            @endphp
                            <select class="form-control" id="durum" name="status">
                                <option value="1" {{ $statu == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ $statu == '0' ? 'selected' : '' }}>Pasif</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                        <a href="{{ route('panel.slider.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
