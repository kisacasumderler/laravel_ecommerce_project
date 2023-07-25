@extends('backend.layout.app')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @if (!empty($setting->id))
                        setting Güncelle
                    @else
                        setting Ekle
                    @endif
                </h4>
                <p class="card-description">
                    setting Ekleme Formu
                </p>
                @php
                    if (!empty($setting->id)) {
                        $routeLink = route('panel.setting.update', $setting->id);
                    } else {
                        $routeLink = route('panel.setting.store');
                    }
                @endphp
                <form action="{{ $routeLink }}" class="forms-sample" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($setting->id))
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="set_type">Set Type</label>
                        <select name="set_type" id="set_type" class="form-control">
                            <option value="">Tür Seçiniz</option>
                            <option value="ckeditor"
                                {{ isset($setting->set_type) && $setting->set_type == 'ckeditor' ? 'selected' : '' }}>Ck
                                Editor</option>
                            <option value="textArea"
                                {{ isset($setting->set_type) && $setting->set_type == 'textArea' ? 'selected' : '' }}>
                                TextArea
                            </option>
                            <option value="file"
                                {{ isset($setting->set_type) && $setting->set_type == 'file' ? 'selected' : '' }}>File
                            </option>
                            <option value="image"
                                {{ isset($setting->set_type) && $setting->set_type == 'image' ? 'selected' : '' }}>Resim
                            </option>
                            <option value="text"
                                {{ isset($setting->set_type) && $setting->set_type == 'text' ? 'selected' : '' }}>Text
                            </option>
                            <option value="email"
                                {{ isset($setting->set_type) && $setting->set_type == 'email' ? 'selected' : '' }}>Email
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Key</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $setting->name ?? '' }}" placeholder="setting Key">
                    </div>
                    <div class="form-group">
                        <label for="value">Value</label>
                        <div class="inputContent">
                            @if (isset($setting->set_type) && $setting->set_type == 'ckeditor')
                                <textarea name="data" id="value" cols="30" rows="10" class="editor">{{ $setting->data ?? '' }}</textarea>
                            @elseif (isset($setting->set_type) && $setting->set_type == 'textarea')
                                <textarea name="data" id="value" cols="30" rows="10" class="form-control">{{ $setting->data ?? '' }}</textarea>
                            @elseif (
                                (isset($setting->set_type) && $setting->set_type == 'file') ||
                                    (isset($setting->set_type) && $setting->set_type == 'image'))
                                <div class="form-group">
                                    <input type="file" name="image" class="file-upload-default">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled
                                            placeholder="Resim Yükle" value="{{ $setting->data ?? '' }}">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button">Yükle</button>
                                        </span>
                                    </div>
                                </div>
                            @elseif (isset($setting->set_type) && $setting->set_type == 'text')
                                <input type="text" class="form-control" id="value" name="data"
                                    value="{{ $setting->data ?? '' }}">
                            @elseif (isset($setting->set_type) && $setting->set_type == 'email')
                                <input type="email" class="form-control" id="value" name="data"
                                    value="{{ $setting->data ?? '' }}">
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    <a href="{{ route('panel.setting.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script src="{{asset('backend/js/cdn.ckeditor.com_ckeditor5_38.1.0_classic_ckeditor.js')}}"></script>
    <script src="{{asset('backend/js/cdn.ckeditor.com_ckeditor5_38.1.0_classic_translations_tr.js')}}"></script>
    <script>
        function ckEditor() {
            ClassicEditor
                .create(document.querySelector('.editor'), {
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

        @if ( isset($setting->set_type) && $setting->set_type == 'ckeditor' )
        ckEditor();
        @endif

        $(document).on('change', '#set_type', function(e) {
            selectType = $(this).val();
            createInput(selectType);
        });

        defaultText = "{!!  isset($setting->data) ? $setting->data : '' !!}";

        function createInput(type) {

            if (type === 'text') {
                newInput = $('<input>').attr({
                    type: 'text',
                    name: 'data',
                    value: defaultText,
                    class: 'form-control',
                    placeholder: 'Value Giriniz',
                    id : 'value'
                });
            }else  if (type === 'email') {
                newInput = $('<input>').attr({
                    type: 'email',
                    name: 'data',
                    class: 'form-control',
                    placeholder: 'Value Giriniz',
                    id : 'value',
                    value: defaultText,
                });
            }else  if (type === 'file' || type === 'image') {
                newInput = $('<input>').attr({
                    type: 'file',
                    name: 'image',
                    class: 'form-control file-upload-info',
                    placeholder: 'Value Giriniz',
                    id : 'value',
                    value: defaultText,
                });
            }
            else  if (type === 'ckeditor') {
                newInput = $('<textarea>').attr({
                    name: 'data',
                    class: 'form-control editor',
                    placeholder: 'Value Giriniz',
                    id : 'value',
                }).val(defaultText);
            }
            else  if (type === 'textArea') {
                newInput = $('<textarea>').attr({
                    name: 'data',
                    class: 'form-control',
                    placeholder: 'Value Giriniz',
                    id : 'value',
                    value: defaultText,
                }).val(defaultText);;
            }

            $('.inputContent').empty().append(newInput);
                if(type === 'ckeditor') {
                    ckEditor();
                }
        }
    </script>
@endsection

