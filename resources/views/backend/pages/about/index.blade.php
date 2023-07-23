@extends('backend.layout.app')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Hakkımızda
                </h4>
                <p class="card-description">

                </p>
                <form action="{{ route('panel.about.update') }}" class="forms-sample" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Başlık</label>
                        @error('name')
                            <span class="text-danger text-small">{{ $message }}</span>
                        @enderror
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') ?? ($about->name ?? '') }}" value="about Başlık">
                    </div>
                    <div class="form-group">
                        <label for="editor">İçerik</label>
                        @error('content')
                            <span class="text-danger text-small">{{ $message }}</span>
                        @enderror
                        <textarea type="text" class="form-control" id="editor" name="content" rows="10">{{ old('content') ?? (htmlspecialchars_decode($about->content) ?? '') }} </textarea>
                    </div>
                    @for ($i = 1; $i < 4; $i++)
                        @php
                            $text = $about->{'text_' . $i};
                            $text_icon = $about->{'text_' . $i . '_icon'};
                            $text_content = $about->{'text_' . $i . '_content'};
                        @endphp
                        <div class="form-group">
                            <label for="text_{{ $i }}">text {{ $i }}</label>
                            @error('text_' . $i)
                                <span class="text-danger text-small">{{ $message }}</span>
                            @enderror
                            <input type="text" class="form-control" id="text_{{ $i }}"
                                name="text_{{ $i }}" value="{{ old('text' . $i) ?? ($text ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="text_{{ $i }}_icon">text {{ $i }} icon</label>
                            @error('text_' . $i . '_icon')
                                <span class="text-danger text-small">{{ $message }}</span>
                            @enderror
                            <input type="text" class="form-control" id="text_{{ $i }}_icon"
                                name="text_{{ $i }}_icon" value="{{ $text_icon ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="text_{{ $i }}_content">text {{ $i }} content</label>
                            @error('text_' . $i . '_content')
                                <span class="text-danger text-small">{{ $message }}</span>
                            @enderror
                            <input type="text" class="form-control" id="text_{{ $i }}_content"
                                name="text_{{ $i }}_content" value="{{ $text_content ?? '' }}">
                        </div>
                    @endfor
                    <div class="form-row align-items-end">
                        <div class="col">
                            <div class="form-group text-center">
                                <p class="text-left">Hakkımızda resim (900x600): </p>
                                <img src="{{ asset($about->image ?? 'images/resimyok.jpg') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <div class="form-group">
                                <label>File upload</label>
                                <input type="file" name="image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Resim Yükle" value="{{ $about->image ?? '' }}">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Yükle</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    <a href="{{ route('panel.about.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script src="{{ asset('backend/js/cdn.ckeditor.com_ckeditor5_38.1.0_classic_ckeditor.js') }}"></script>
    <script src="{{ asset('backend/js/cdn.ckeditor.com_ckeditor5_38.1.0_classic_translations_tr.js') }}"></script>
    <script>
        function CkEditor() {

            ClassicEditor
                .create(document.querySelector('#editor'), {
                    language: 'tr',
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            },
                            {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3'
                            },
                            {
                                model: 'heading4',
                                view: 'h4',
                                title: 'Heading 4',
                                class: 'ck-heading_heading4'
                            },
                            {
                                model: 'heading5',
                                view: 'h5',
                                title: 'Heading 5',
                                class: 'ck-heading_heading5'
                            },
                            {
                                model: 'heading6',
                                view: 'h6',
                                title: 'Heading 6',
                                class: 'ck-heading_heading6'
                            }
                        ]
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
        CkEditor();

    </script>
@endsection
