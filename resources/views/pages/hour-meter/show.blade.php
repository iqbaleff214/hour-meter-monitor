@extends('layouts.content')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="py-3 mb-0">
            <a class="text-muted fw-light" href="{{ route('report.hour-meter.index') }}">Hour Meter /</a> Laporan {{ $report->created_at->isoFormat('Y-MM-DD') }}
        </h4>
        <div>
            <a href="{{ route('report.hour-meter.export', $report) }}" class="btn btn-light btn-sm fw-medium" download="{{ $report->created_at->isoFormat('Y-MM-DD') . '_' . $report->subsidiary?->name . '.csv' }}">
                <i class="bx bx-download"></i>
            </a>
        </div>
    </div>

    @foreach($details as $category => $reports)
    <div class="card mb-4">
        <h4 class="card-header p-3">{{ $category }}</h4>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Unit</th>
                    <th>Model</th>
                    <th>Kategori Unit</th>
                    <th>Hour Meter</th>
                    <th>Detail Servis</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach ($reports as $index => $report)<tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="fw-semibold">{{ $report->equipment?->code }}</div>
                        SN. {{ $report->equipment?->serial_number }}
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $report->equipment?->brand }}</div>
                        {{ $report->equipment?->model }}
                    </td>
                    <td>{{ $report->equipment?->category->name }}</td>
                    <td>{{ $report->new_hour_meter }}</td>
                    <td>{{ $report->service_plan ?? '-' }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

@endsection
