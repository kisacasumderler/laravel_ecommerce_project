@extends('backend.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Striped Table</h4>
                    <p class="card-description">
                        <a href="{{ route('panel.coupons.create') }}" class="btn btn-primary">Kupon Ekle</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        İsim
                                    </th>
                                    <th>
                                        tutar
                                    </th>
                                    <th>
                                        İndirim Oranı
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
                                @if (!empty($coupons) && $coupons->count() > 0)
                                    @foreach ($coupons as $coupon)
                                        <tr class="item" item-id='{{ $coupon->id }}'>
                                            <td class="py-1">
                                                {{ $coupon->name }}
                                            </td>
                                            <td>
                                                {{$coupon->price ?? '0'}}
                                            </td>
                                            <td >
                                                {{$coupon->discount_rate ?? '0'}}
                                            </td>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" {{ $coupon->status == '1' ? 'checked' : '' }}
                                                            data-on='Aktif' data-off='Pasif' data-toggle="toggle"
                                                            class="durum" data-onstyle='success' data-offstyle='danger'>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="d-flex justify-content-center align-items-center" style="gap: .3rem">
                                                <a href="{{ route('panel.coupons.edit', $coupon->id) }}"
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
                    url: "{{ route('panel.coupons.status') }}",
                    data: {
                        id: id,
                        statu: statu
                    },
                    success: function(response) {
                        if (response.status == '1') {
                            toastr.success("Durum aktif edildi.");
                        } else {
                            toastr.error("Durum Pasif edildi");
                        }
                    }
                })
            })

            $(document).on('click', '.SilBtn', function(e) {
                e.preventDefault();

                let item = $(this).closest('.item'),
                    id = item.attr('item-id');


                alertify.confirm('Slider Kaldır',
                    'Slider ile ilgili tüm veriler kaldırılacaktır. Silmek istediğinizden emin misiniz?',
                    function() {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: `{{ route('panel.coupons.destroy') }}`,
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
