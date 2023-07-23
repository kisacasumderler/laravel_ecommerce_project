@extends('backend.layout.app')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Mesaj Detay
                </h4>
                <form action="{{ route('panel.contact.update', $contact->id) }}" class="forms-sample" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (!empty($contact->id))
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <h4>İsim Soyisim</h4>
                        <p class="p-1 bg-light text-dark">{{ DonusumleriGeriDondur($contact->name) ?? ''}}</p>
                    </div>
                    <div class="form-group">
                        <h4>Email</h4>
                        <p class="p-1 bg-light text-dark">{{ DonusumleriGeriDondur($contact->email) ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <h4>Kullanıcı Ip adres</h4>
                        <p class="p-1 bg-light text-dark">{{ $contact->ip ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <h4>Konu</h4>
                        <p class="p-1 bg-light text-dark">{{ DonusumleriGeriDondur($contact->subject) ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <h4 for="icerik">Mesaj</h4>
                        <p class="p-1 bg-light" >{{ DonusumleriGeriDondur($contact->message) ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="durum">Durum</label>
                        @error('status')
                            <span class="text-danger">{{$messages}}</span>
                        @enderror
                        @php
                            $statu = $contact->status ?? '1';
                        @endphp
                        <select class="form-control" id="durum" name="status">
                            <option value="1" {{ $statu == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $statu == '0' ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    <a href="{{ route('panel.contact.index') }}" class="btn btn-light">İptal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script>
        @if (session()->get('success'))
            alertify.success('{{ session()->get("success") }}');
        @endif
        @if ($errors)
            @foreach ($errors->all() as $error)
                alertify.error('{{ $error }}')
            @endforeach
        @endif
    </script>
@endsection
