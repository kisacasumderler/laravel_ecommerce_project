@extends('backend.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Siparişler</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        İsim Soyisim
                                    </th>
                                    <th>
                                        sipariş No
                                    </th>
                                    <th>
                                        Sepet Ürün Sayısı
                                    </th>
                                    <th>
                                        Telefon
                                    </th>
                                    <th>
                                        Adres
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
                                @if (!empty($orders) && $orders->count() > 0)
                                    @foreach ($orders as $order)
                                        <tr class="item" item-id='{{ $order->id }}'>
                                            <td class="py-1">
                                                {{ $order->c_name }}
                                            </td>
                                            <td class="text-wrap">
                                                {{ $order->order_no }}
                                            </td>
                                            <td class="text-wrap">
                                                {{ $order->orders_count ?? '' }}
                                            </td>
                                            <td>
                                                {{ $order->c_phone ?? '' }}
                                            </td>
                                            <td class="text-wrap">
                                                @php
                                                    $address = $order->c_address . '<br>' . $order->c_state_country . '<br>' . $order->c_city . '/' . $order->c_country . '<br>' . $order->c_postal_zip;
                                                @endphp
                                                {!! strLimit($address, 150, route('panel.order.edit', $order->id)) ?? '' !!}
                                            </td>
                                            <td>

                                                <label>
                                                    <input type="checkbox" {{ $order->status == '1' ? 'checked' : '' }}
                                                        data-on='Kargoda' data-off='Beklemede' data-toggle="toggle"
                                                        class="durum" data-onstyle='success' data-offstyle='danger'>
                                                </label>

                                            </td>
                                            <td class="d-flex justify-content-center align-items-center" style="gap: .3rem">
                                                <a href="{{ route('panel.order.edit', $order->id) }}"
                                                    class="btn btn-primary">Düzenle</a>
                                                <button type="button" class="SilBtn btn btn-danger">Sil</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row my-5 justify-content-end px-3">
                        {{ $orders->links('pagination::bootstrap-4') }}
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
                    url: "{{ route('panel.order.status') }}",
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


                alertify.confirm('Mesaj Kaldır',
                    'Mesaj ile ilgili tüm veriler kaldırılacaktır. Silmek istediğinizden emin misiniz?',
                    function() {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: `{{ route('panel.order.destroy') }}`,
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
            });
        })
    </script>
@endsection
