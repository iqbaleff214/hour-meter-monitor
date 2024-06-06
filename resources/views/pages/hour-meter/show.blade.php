@extends('layouts.content')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="py-3 mb-0">
            <a class="text-muted fw-light" href="{{ route('report.hour-meter.index') }}">Hour Meter /</a> Laporan {{ $report->created_at->isoFormat('Y-MM-DD') }}
        </h4>
    </div>

    <div class="card mb-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Kode Unit</th>
                    <th>Model</th>
                    <th>Kategori Unit</th>
                    <th>Hour Meter</th>
                    <th>Detail Servis</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach ($report?->details ?? [] as $report)<tr>
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

@endsection
