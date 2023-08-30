@extends('backend.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Site Ayarları</h4>
                    <p class="card-description">
                        <a href="{{ route('panel.setting.create') }}" class="btn btn-primary">Yeni setting</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Resim
                                    </th>
                                    <th>
                                        Key
                                    </th>
                                    <th>
                                        Value
                                    </th>
                                    <th>
                                        Edit
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($sets) && $sets->count() > 0)
                                    @foreach ($sets as $setting)
                                        <tr class="item" item-id='{{ $setting->id }}'>
                                            <td class="py-1">
                                                @if ($setting->set_type == 'image')
                                                    <img src="{{ asset($setting->data) }}" alt="image" />
                                                @endif
                                            </td>
                                            <td class="text-wrap">
                                                {{ $setting->name }}
                                            </td>
                                            <td class="text-wrap">
                                                {!! $setting->data ?? '&nbsp' !!}
                                            </td>
                                            <td>
                                                {{ $setting->set_type ?? ' ' }}
                                            </td>
                                            <td class="d-flex justify-content-center align-items-center" style="gap: .3rem">
                                                <a href="{{ route('panel.setting.edit', $setting->id) }}"
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


            alertify.confirm('setting Kaldır', 'setting ile ilgili tüm veriler kaldırılacaktır. Silmek istediğinizden emin misiniz?', function() {
                $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                url: `{{ route('panel.setting.destroy') }}`,
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.error == false) {
                        item.remove();
                        toastr.success(response.message);
                    }else {
                        toastr.error("işlem sırasında hata alınmaktadır.");
                    }
                }
            })
            }, function() {
                toastr.error('Cancel')
            });
        });
        })
    </script>
@endsection
