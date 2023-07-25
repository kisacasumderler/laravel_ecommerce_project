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
                        <textarea type="text" class="form-control" id="icerik" name="content">{{  old('content') ?? ($slider->content ?? '') }} </textarea>
                    </div>
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" class="form-control" id="link" placeholder="Slider linki" name="link"
                            value="{{ old('link') ?? ($slider->link ?? '')}}">
                    </div>
                    <div class="form-row align-items-end">
                        <div class="col">
                            <div class="form-group">
                                <p>Masaüstü Tasarım(1600x600): </p>
                                <img src="{{ asset($slider->image ?? 'images/resimyok.jpg') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <div class="form-group">
                                <label>File upload</label>
                                <input type="file" name="image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Resim Yükle" value="{{ old('image') ?? ($slider->image ?? '')}}">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Yükle</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <p>Mobil Tasarım(1000x1000): </p>
                                <img src="{{ asset($slider->MobileImage ?? 'images/resimyok.jpg') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <div class="form-group">
                                <label>File upload</label>
                                <input type="file" name="MobileImage" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Mobil Versiyon Resim Yükle" value="{{ old('MobileImage') ?? ($slider->MobileImage ?? '')}}">
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

