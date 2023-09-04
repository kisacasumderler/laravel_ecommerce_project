@extends('backend.layout.app')
@section('content')
    <div class="contariner">
        <div class="row">
            <h1>Raporlar</h1>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Sipariş Sayısı </p>
                                <p class="fs-30 mb-2">{{ $mounthTotalOrderCount }}</p>
                                <p>0% (Aylık)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Sipriş Kazanç </p>
                                <p class="fs-30 mb-2">{{ $mounthTotalOrderPrice }}₺</p>
                                <p>0% (Aylık)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Sipriş Sayısı (Tüm Siparişler) </p>
                                <p class="fs-30 mb-2">{{ $TotalOrderCount }}</p>
                                <p>0% (Genel)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Sipriş Kazanç (Tüm saparişler)</p>
                                <p class="fs-30 mb-2">{{ $TotalOrderPrice }}₺</p>
                                <p>0% (Genel)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Order Details</p>
                        <p class="font-weight-500">The total number of sessions within the date range. It is the period time
                            a user is actively engaged with your website, page or app, etc</p>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="mr-5 mt-3">
                                <p class="text-muted">Order value</p>
                                <h3 class="text-primary fs-30 font-weight-medium">12.3k</h3>
                            </div>
                            <div class="mr-5 mt-3">
                                <p class="text-muted">Orders</p>
                                <h3 class="text-primary fs-30 font-weight-medium">14k</h3>
                            </div>
                            <div class="mr-5 mt-3">
                                <p class="text-muted">Users</p>
                                <h3 class="text-primary fs-30 font-weight-medium">71.56%</h3>
                            </div>
                            <div class="mt-3">
                                <p class="text-muted">Downloads</p>
                                <h3 class="text-primary fs-30 font-weight-medium">34040</h3>
                            </div>
                        </div>
                        <canvas id="order-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Sales Report</p>
                            <a href="#" class="text-info">View all</a>
                        </div>
                        <p class="font-weight-500">The total number of sessions within the date range. It is the period time
                            a user is actively engaged with your website, page or app, etc</p>
                        <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
                        <canvas id="sales-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Top Products</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>Ürün Fotoğrafı</th>
                                        <th>Ürün Adı</th>
                                        <th>Toplam Satış</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty('topProducts') && $topProducts->count() > 0)
                                        @foreach ($topProducts as $topProduct)
                                       @isset($topProduct->product->images)
                                            @php
                                                $image = collect($topProduct->product->images->data)->sortByDesc('vitrin')->first()['image'];
                                            @endphp
                                       @endisset
                                            <tr>
                                                <td>
                                                    <img src="{{asset($image ?? 'images/resimyok.jpg')}}" alt="{{str_replace(' ','-',$topProduct->product->name ?? '')}}">
                                                </td>
                                                <td class="font-weight-bold">{{$topProduct->product->name ?? 'Ürün Bulunamadı'}}</td>
                                                <td>{{$topProduct->total_sold ?? '0'}}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">To Do Lists</h4>
                        <div class="list-wrapper pt-2">
                            <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                                <li>
                                    <div class="form-check form-check-flat">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Meeting with Urban Team
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check form-check-flat">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" checked>
                                            Duplicate a project for new customer
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li>
                                    <div class="form-check form-check-flat">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Project meeting with CEO
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check form-check-flat">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" checked>
                                            Follow up of team zilla
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li>
                                    <div class="form-check form-check-flat">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Level up for Antony
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                            </ul>
                        </div>
                        <div class="add-items d-flex mb-0 mt-2">
                            <input type="text" class="form-control todo-list-input" placeholder="Add new task">
                            <button class="add btn btn-icon text-primary todo-list-add-btn bg-transparent"><i
                                    class="icon-circle-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
