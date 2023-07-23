@extends('backend.layout.app')
@section('content')
<div class="form-group">
    <input type="text" class="form-control" id="myInput" placeholder="tabloda ara">
</div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ürünler Tablosu</h4>
                    <p class="card-description">
                        <a href="{{ route('panel.product.create') }}" class="btn btn-primary">Yeni Ürün</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Resim
                                    </th>
                                    <th>
                                        İsim
                                    </th>
                                    <th>
                                        Fiyat
                                    </th>
                                    <th>
                                        Adet
                                    </th>
                                    <th>
                                        Statü
                                    </th>
                                    <th>
                                        Edit
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                @if (!empty($products) && $products->count() > 0)
                                    @foreach ($products as $product)
                                        <tr class="item" item-id='{{ $product->id }}'>
                                            <td class="py-1">
                                                <img src="{{ asset($product->image) }}" alt="image" />
                                            </td>
                                            <td class="text-wrap">
                                                {{ $product->name }}
                                            </td>
                                            <td class="text-wrap">
                                                {{ number_format($product->price, 2) }}₺
                                            </td>
                                            <td class="text-wrap">
                                                {{ $product->qty }}
                                            </td>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox"
                                                            {{ $product->status == '1' ? 'checked' : '' }} data-on='Aktif'
                                                            data-off='Pasif' data-toggle="toggle" class="durum"
                                                            data-onstyle='success' data-offstyle='danger'>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="d-flex justify-content-center align-items-center" style="gap: .3rem">
                                                <a href="{{ route('panel.product.edit', $product->id) }}"
                                                    class="btn btn-primary">Düzenle</a>
                                                <button type="button" class="SilBtn btn btn-danger">Sil</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-center my-3 p-1 paginateButtons">
                        {{ $products->withQueryString()->links('pagination::bootstrap-4') }} </div>
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
                    url: "{{ route('panel.product.status') }}",
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


                alertify.confirm('Ürünü Kaldır',
                    'Ürün ile ilgili tüm veriler kaldırılacaktır. Silmek istediğinizden emin misiniz?',
                    function() {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: `{{ route('panel.product.destroy') }}`,
                            data: {
                                id: id
                            },
                            success: function(response) {
                                if (response.error == false) {
                                    item.remove();
                                    alertify.success(response.message);
                                } else {
                                    alertify.error("işlem sırasında hata alınmaktadır.");
                                }
                            }
                        })
                    },
                    function() {
                        alertify.error('Cancel')
                    });
            })





            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
