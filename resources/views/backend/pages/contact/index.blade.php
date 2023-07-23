@extends('backend.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Mesajlar</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        isim
                                    </th>
                                    <th>
                                        email
                                    </th>
                                    <th>
                                        konu
                                    </th>
                                    <th>
                                        mesaj
                                    </th>
                                    <th>
                                        Ip
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
                                @if (!empty($contacts) && $contacts->count() > 0)
                                    @foreach ($contacts as $contact)
                                        <tr class="item" item-id='{{ $contact->id }}'>
                                            <td class="py-1">
                                                {{ $contact->name }}
                                            </td>
                                            <td class="text-wrap">
                                                {{ $contact->email }}
                                            </td>
                                            <td class="text-wrap">
                                                {{ $contact->subject ?? '' }}
                                            </td>
                                            <td class="text-wrap">
                                                {!! strLimit($contact->message, 150, route('panel.contact.edit', $contact->id)) ?? '' !!}
                                            </td>
                                            <td>
                                                {{ $contact->ip ?? '' }}
                                            </td>

                                            <td>
                                                <label>
                                                    <input type="checkbox" {{ $contact->status == '1' ? 'checked' : '' }}
                                                        data-on='Aktif' data-off='Pasif' data-toggle="toggle" class="durum"
                                                        data-onstyle='success' data-offstyle='danger'>
                                                </label>
                                            </td>
                                            <td class="d-flex justify-content-center align-items-center" style="gap: .3rem">
                                                <a href="{{ route('panel.contact.edit', $contact->id) }}"
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
                        {{ $contacts->links('pagination::bootstrap-4') }}
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
                    url: "{{ route('panel.contact.status') }}",
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


                alertify.confirm('Mesaj Kaldır',
                    'Mesaj ile ilgili tüm veriler kaldırılacaktır. Silmek istediğinizden emin misiniz?',
                    function() {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: `{{ route('panel.contact.destroy') }}`,
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
            });
        })
    </script>
@endsection
