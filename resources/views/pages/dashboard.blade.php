@extends('layouts.content')

@section('content')
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat datang, {{ auth()->user()->name }} 🎉</h5>
                            @if($submitted)
                                <p class="mb-4">Anda belum mengirimkan laporan hour meter hari ini.</p>

                                <a href="{{ route('report.hour-meter.create') }}" target="_blank"
                                   class="btn btn-sm btn-outline-primary">Buat Laporan Hour Meter</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{asset('assets/img/illustrations/man-with-laptop-light.png')}}" height="140"
                                 alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                 data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                    <div class="card-title">
                                        <h5 class="text-nowrap mb-2">Laporan HM Unit Peralatan</h5>
                                        <span class="badge bg-label-warning rounded-pill">7 Hari Terakhir</span>
                                    </div>
                                    <div class="mt-sm-auto">
                                        @if($chart['equipment_report']['totalIncrement'] >= 0)
                                            <small class="text-success text-nowrap fw-medium">
                                                <i class='bx bx-chevron-up'></i> {{ $chart['equipment_report']['totalIncrement'] }}
                                                %
                                            </small>
                                        @else
                                            <small class="text-danger text-nowrap fw-medium">
                                                <i class='bx bx-chevron-down'></i> {{ $chart['equipment_report']['totalIncrement'] }}
                                                %
                                            </small>
                                        @endif
                                        <h3 class="mb-0">{{ $chart['equipment_report']['total'] }}</h3>
                                    </div>
                                </div>
                                <div id="equipmentReportChart"
                                     data-chart="{{ json_encode($chart['equipment_report']) }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row" style="min-height: 100%">
                @foreach($summary['top3'] as $top3)
                    <div class="col-6 mb-4">
                        <div class="card" style="min-height: 100%">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex mb-1 flex-column">
                                    <small>Brand</small>
                                    <span class="d-block fw-bold">{{ $top3->brand }}</span>
                                </div>
                                <div class="d-flex align-items-end mt-3 justify-content-end">
                                    <h3 class="card-title text-nowrap my-0 me-2">{{ $top3->total }}</h3>
                                    <small>Unit</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-6 mb-4">
                    <div class="card" style="min-height: 100%">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex mb-1 flex-column">
                                <small>Brand</small>
                                <span class="d-block fw-bold">Lainnya</span>
                            </div>
                            <div class="d-flex align-items-end mt-3 justify-content-end">
                                <h3 class="card-title text-nowrap my-0 me-2">{{ $summary['other'] }}</h3>
                                <small>Unit</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-12">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="m-0 me-2 pb-3">Kondisi Alat pada Laporan Hour Meter</h5>
                            <small>7 Hari Terakhir</small>
                        </div>
                        <div id="conditionReportChart"
                             data-chart="{{ json_encode($chart['condition_report']) }}" class="px-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Total Revenue -->
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endpush

@push('script')
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endpush
