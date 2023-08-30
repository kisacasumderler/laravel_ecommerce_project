@extends('backend.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Striped Table</h4>
                    <p class="card-description">
                        <a href="{{ route('panel.pageseo.create') }}" class="btn btn-primary">Yeni Sayfa Seo</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Resim</th>
                                    <th>Alt</th>
                                    <th>edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($images))
                                    @foreach ($images as $image)
                                        @if (!empty($image))
                                            @foreach ($image as $img)
                                                <tr class="item" item-id='{{ $img['image_no'] }}'>
                                                    <td class="py-1">
                                                        <img src="{{ asset($img['image'] ?? 'img/resimyok.png') }}" />
                                                    </td>
                                                    <td>
                                                        <input type="text" value="{{ $img['alt'] ?? '' }}"
                                                            class="imgAlt">
                                                    </td>
                                                    <td class="d-flex justify-content-center align-items-center"
                                                        style="gap: .3rem">
                                                        <button class="btn btn-primary saveBtn">Kaydet</button>
                                                        <button type="button" class="SilBtn btn btn-danger">Sil</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.saveBtn', function(e) {
                e.preventDefault();
                var item = $(this).closest('.item');
                id = item.attr('item-id');
                imageAlt = item.find('.imgAlt').val();
                console.log(imageAlt);
                alertify.confirm("Alt güncelelnecektir ?", "Emin misin ?",
                    function() {

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: "{{ route('panel.imageseo.update') }}",
                            data: {
                                id: id,
                                imageAlt: imageAlt,
                            },
                            success: function(response) {
                                if (response.error == false) {
                                    alertify.success(response.message);
                                } else {
                                    alertify.error("Bir Hata Oluştu");
                                }
                            }
                        });
                    },
                    function() {
                        alertify.error('Güncelleme İptal edildi');
                    });
            });

            $(document).on('click', '.SilBtn', function(e) {
                e.preventDefault();
                var item = $(this).closest('.item');
                id = item.attr('item-id');
                alertify.confirm("Silmek İstediğine Eminmisin?", "Silmek İstediğine Eminmisin?",
                    function() {

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: "{{ route('panel.imageseo.destroy') }}",
                            data: {
                                id: id,
                            },
                            success: function(response) {
                                if (response.error == false) {
                                    item.remove();
                                    alertify.success(response.message);
                                } else {
                                    alertify.error("Bir Hata Oluştu");
                                }
                            }
                        });
                    },
                    function() {
                        alertify.error('Silme İptal Edildi');
                    });
            });
        })
    </script>
@endsection
