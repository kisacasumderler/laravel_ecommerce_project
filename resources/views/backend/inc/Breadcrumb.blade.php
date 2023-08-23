<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="{{ route('anasayfa') }}">Anasayfa</a> <span class="mx-2 mb-0">/</span>
                @if (!empty($Breadcrumb['sayfalar']))
                    @foreach ($Breadcrumb['sayfalar'] as $item)
                    <a href="{{$item['link']}}">{{$item['name']}}</a> <span class="mx-2 mb-0">/</span>
                    @endforeach
                @endif
                <strong class="text-black">{{$Breadcrumb['active']}}</strong>
            </div>
        </div>
    </div>
</div>
