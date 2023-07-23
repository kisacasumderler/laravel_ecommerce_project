@extends('backend.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Striped Table</h4>
                    <p class="card-description">
                        <a href="{{ route('panel.slider.create') }}" class="btn btn-primary">Yeni Slider</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Resim
                                    </th>
                                    <th>
                                        Başlık
                                    </th>
                                    <th>
                                        Slogan
                                    </th>
                                    <th>
                                        Link
                                    </th>
                                    <th>
                                        Durum
                                    </th>
                                    <th>
                                        Edit
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($sliders) && $sliders->count() > 0)
                                    @foreach ($sliders as $slider)
                                        <tr class="item" item-id='{{ $slider->id }}'>
                                            <td class="py-1">
                                                <img src="{{ asset($slider->image) }}" alt="image" />
                                            </td>
                                            <td class="text-wrap">
                                                {{ $slider->name }}
                                            </td>
                                            <td class="text-wrap">
                                                {!! $slider->content ?? '&nbsp' !!}
                                            </td>
                                            <td>
                                                {{ $slider->link ?? ' ' }}
                                            </td>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" {{ $slider->status == '1' ? 'checked' : '' }}
                                                            data-on='Aktif' data-off='Pasif' data-toggle="toggle"
                                                            class="durum" data-onstyle='success' data-offstyle='danger'>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="d-flex justify-content-center align-items-center" style="gap: .3rem">
                                                <a href="{{ route('panel.slider.edit', $slider->id) }}"
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
            $(document).on('change', '.durum', function(e) {
            id = $(this).closest('.item').attr('item-id');
            statu = $(this).prop('checked');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('panel.slider.status') }}",
                data: {
                    id: id,
                    statu: statu
                },
                success: function(response) {
                    if (response.status == '1') {
                        alertify.success("Durum aktif edildi.");
                    } else {
                        alertify.error("Durum Pasif edildi");
                    }
                }
            })
        })

        $(document).on('click', '.SilBtn', function(e) {
            e.preventDefault();

            let item = $(this).closest('.item'),
            id = item.attr('item-id');


            alertify.confirm('Slider Kaldır', 'Slider ile ilgili tüm veriler kaldırılacaktır. Silmek istediğinizden emin misiniz?', function() {
                $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                url: `{{ route('panel.slider.destroy') }}`,
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.error == false) {
                        item.remove();
                        alertify.success(response.message);
                    }else {
                        alertify.error("işlem sırasında hata alınmaktadır.");
                    }
                }
            })
            }, function() {
                alertify.error('Cancel')
            });


        })
        })
    </script>
@endsection
