@extends('backend.layout.app')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @if (!empty($category->id))
                    <h4>Kategori Güncelle</h4>
                    <p>Kategori Güncelleme Formu</p>
                @else
                    <h4>Kategori Ekle</h4>
                    <p>Kategori Ekleme Formu</p>
                @endif
                @php
                    if (!empty($category->id)) {
                        $routeLink = route('panel.category.update', $category->id);
                    } else {
                        $routeLink = route('panel.category.store');
                    }
                @endphp
                <form action="{{ $routeLink }}" class="forms-sample" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($category->id))
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="name">Kategori adı</label>
                        @error('name')
                            <span class="text-danger text-small">{{ $message }}</span>
                        @enderror
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') ?? ($category->name ?? '') }}" placeholder="Kategori adı">
                    </div>
                    <div class="form-group">
                        <label for="ustKategori">Üst Kategori Adı</label>
                        @error('cat_ust')
                            <span class="text-danger text-small">{{ $message }}</span>
                        @enderror
                        <select name="cat_ust" id="ustKategori" class="form-control">
                            <option value="">Kategori Seç</option>
                            @foreach ($categories as $alt)
                                <option value="{{ old('name') ?? ($alt->id ?? '') }}"
                                    @isset($category)
{{ $category->cat_ust == $alt->id ? 'selected' : '' }}
                                @endisset>
                                    {{ $alt->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="icerik">İçerik Yazısı</label>
                        @error('content')
                            <span class="text-danger text-small">{{ $message }}</span>
                        @enderror
                        <textarea name="content" id="icerik" cols="30" rows="10" class="form-control">{{ old('content') ?? ($category->content ?? '') }}</textarea>
                    </div>
                    <div class="form-row align-items-end">
                        <div class="col">
                            <div class="form-group">
                                <p>Ana Kategori (900x1182), Alt Kategori (800,350) </p>
                                <img src="{{ asset($category->image ?? 'images/resimyok.jpg') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <div class="form-group">
                                <label>File upload</label>
                                @error('image')
                                    <span class="text-danger text-small">{{ $message }}</span>
                                @enderror
                                <input type="file" name="image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Resim Yükle" value="{{ old('image') ?? ($category->image ?? '') }}">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Yükle</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="durum">Durum</label>
                        @error('status')
                            <span class="text-danger text-small">{{ $message }}</span>
                        @enderror
                        @php
                            $statu = $category->status ?? '1';
                        @endphp
                        <select class="form-control" id="durum" name="status">
                            <option value="1" {{ $statu == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $statu == '0' ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    <a href="{{ route('panel.category.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>
@endsection


