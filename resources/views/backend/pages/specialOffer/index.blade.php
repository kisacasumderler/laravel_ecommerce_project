@extends('backend.layout.app')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Kampanya / Özel Teklif
                </h4>
                <p class="card-description">
                    Kampanya bilgilendirme formu
                </p>
                <div class="my-2 d-flex justify-content-end flex-row item" item-id='{{ isset($offer->id) }}'>
                    <input type="checkbox" {{ $offer->status == '1' ? 'checked' : '' }} data-on='Yayından Kaldır'
                        data-off='Yayınla' data-toggle="toggle" class="durum" data-onstyle='danger' data-offstyle='success'>
                </div>
                <form action="{{ route('panel.offer.update') }}" class="forms-sample" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">İsim</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $offer->name ?? '' }}" placeholder="Kampanya İsmini buraya giriniz">
                    </div>
                    <div class="form-group">
                        <label for="title">Başlık</label>
                        <input type="text" class="form-control" id="title" name="title" rows="10"
                            value="{{ $offer->title ?? '' }}" placeholder="Kampanya Bilgilendirme Başlık giriniz.">
                    </div>
                    <div class="form-group">
                        <label for="editor">Mesaj</label>
                        <textarea type="text" class="form-control" id="editor" name="message" rows="10"> {{ $offer->message ?? 'Kampanya Bilgilendirme metni giriniz.' }} </textarea>
                    </div>
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" value="indirimdekiurunler" class="form-control" name="link" id="link" disabled>
                    </div>
                    <div class="form-row align-items-end">
                        <div class="col">
                            <div class="form-group text-center">
                                <p class="text-left">Hakkımızda resim (900x600): </p>
                                <img src="{{ asset($offer->image ?? '') }}" alt="" class="img-fluid">
                            </div>
                            <div class="form-group">
                                <label>File upload</label>
                                <input type="file" name="image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Resim Yükle" value="{{ $offer->image ?? '' }}">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Yükle</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    <a href="{{ route('panel.offer.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script src="{{ asset('backend/js/cdn.ckeditor.com_ckeditor5_38.1.0_classic_ckeditor.js') }}"></script>
    <script src="{{ asset('backend/js/cdn.ckeditor.com_ckeditor5_38.1.0_classic_translations_tr.js') }}"></script>
    <script>
        $(document).ready(function() {
            function Ckeditor() {
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
            Ckeditor();

            $(document).on('change', '.durum', function(e) {
                id = $(this).closest('.item').attr('item-id');
                statu = $(this).prop('checked');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('panel.offer.status') }}",
                    data: {
                        id: id,
                        statu: statu
                    },
                    success: function(response) {
                        if (response.status == '1') {
                            alertify.success("Duyuru Yayında.");
                        } else {
                            alertify.error("Duyuru Yayından Kaldırıldı.");
                        }
                    }
                })
            });

            @if (session()->get('success'))
            alertify.success('{{ session()->get("success") }}');
        @endif
        @if ($errors)
            @foreach ($errors->all() as $error)
                alertify.error('{{ $error }}')
            @endforeach
        @endif
        });
    </script>
@endsection
