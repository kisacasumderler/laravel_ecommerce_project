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
                                    <th>Dil</th>
                                    <th>Sayfa</th>
                                    <th>Bilgi</th>
                                    <th>Başlık</th>
                                    <th>description</th>
                                    <th>keywords</th>
                                    <th>edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($pageseos) && $pageseos->count() > 0)
                                    @foreach ($pageseos as $pageseo)
                                        <tr class="item" item-id='{{ $pageseo->id }}'>
                                            <td class="py-1">
                                                @php
                                                    $images = collect($pageseo->images->data ?? '');
                                                @endphp
                                                <img
                                                    src="{{ asset($images->sortByDesc('vitrin')->first()['image'] ?? 'img/resimyok.png') }}" />
                                            </td>
                                            <td>
                                                {{ $pageseo->dil ?? '' }}
                                            </td>
                                            <td>
                                                {{ $pageseo->page ?? '' }}
                                            </td>
                                            <td>
                                                {{ $pageseo->pageinfo->page ?? '' }}
                                            </td>
                                            <td>
                                                {{ $pageseo->title ?? '' }}
                                            </td>
                                            <td>
                                                {{ $pageseo->description ?? '' }}
                                            </td>
                                            <td>
                                                {{ $pageseo->keywords ?? '' }}
                                            </td>
                                            <td class="d-flex justify-content-center align-items-center" style="gap: .3rem">
                                                <a href="{{ route('panel.pageseo.edit', $pageseo->id) }}"
                                                    class="btn btn-primary">Düzenle</a>
                                                <button type="button" class="SilBtn btn btn-danger">Sil</button>
                                            </td>
                                        </tr>
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
            $(document).on('click', '.SilBtn', function(e) {
                e.preventDefault();

                let item = $(this).closest('.item'),
                    id = item.attr('item-id');


                alertify.confirm('pageseo Kaldır',
                    'pageseo ile ilgili tüm veriler kaldırılacaktır. Silmek istediğinizden emin misiniz?',
                    function() {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: `{{ route('panel.pageseo.destroy') }}`,
                            data: {
                                id: id
                            },
                            success: function(response) {
                                if (response.error == false) {
                                    item.remove();
                                    toastr.success(response.message);
                                } else {
                                    toastr.error("işlem sırasında hata alınmaktadır.");
                                }
                            }
                        })
                    },
                    function() {
                        toastr.error('Cancel')
                    });
            })
        })
    </script>
@endsection
