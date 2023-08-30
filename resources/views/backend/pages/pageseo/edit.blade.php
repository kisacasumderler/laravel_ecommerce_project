@extends('backend.layout.app')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @if (!empty($pageseo->id))
                        Sayfa Seo Güncelle
                    @else
                        Sayfa Seo Ekle
                    @endif
                </h4>
                <p class="card-description">
                    Sayfa Seo Ekleme Formu
                </p>
                @php
                    if (!empty($pageseo->id)) {
                        $routeLink = route('panel.pageseo.update', $pageseo->id);
                    } else {
                        $routeLink = route('panel.pageseo.store');
                    }
                @endphp
                <form action="{{ $routeLink }}" class="forms-sample" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($pageseo->id))
                        @method('PUT')
                    @endif
                    {{--
page_ust --}}
                    <div class="form-group">
                        <label for="page">Sayfa</label>
                        <input type="text" class="form-control" id="page" name="page"
                            value="{{ $pageseo->page ?? old('page') }}" placeholder="Orn : Anasayfa">
                    </div>
                    <div class="form-group">
                        <label for="title">Başlık</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $pageseo->title ?? old('title') }}" placeholder="Sayfa Başlık">
                    </div>
                    <div class="form-group">
                        <label for="dil">Dil</label>
                        <input type="text" class="form-control" id="dil" name="dil"
                            value="{{ $pageseo->dil ?? 'tr' ?? old('dil') }}" placeholder="Dil">
                    </div>
                    <div class="form-group">
                        <label for="contents">Contents</label>
                        <textarea type="text" class="form-control" id="contents" name="content">{{ old('contents') ?? ($pageseo->contents ?? '') }} </textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">description</label>
                        <textarea type="text" class="form-control" id="description" name="description">{{ old('description') ?? ($pageseo->description ?? '') }} </textarea>
                    </div>
                    <div class="form-group">
                        <label for="keywords">keywords</label>
                        <textarea type="text" class="form-control" id="keywords" name="keywords">{{ old('keywords') ?? ($pageseo->keywords ?? '') }} </textarea>
                    </div>
                    <div class="col">
                        <div class="col-lg-12 d-flex images">
                            @if (isset($pageseo) && !empty($pageseo->images->data))
                                @php
                                    $images = collect($pageseo->images->data ?? '');
                                @endphp
                                @foreach ($images->sortByDesc('vitrin') as $item)
                                    <div class="item mx-4" data-id="{{ $pageseo->id }}" data-model="PageSeo"
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
                                    placeholder="Resim Yükle" value="{{ old('image') ?? ($pageseo->image ?? '') }}">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Yükle</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    <a href="{{ route('panel.pageseo.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
