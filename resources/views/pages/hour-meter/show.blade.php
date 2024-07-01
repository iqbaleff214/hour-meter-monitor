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
            <table class="table">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Unit</th>
                    <th>Model</th>
                    <th>HM</th>
                    <th>PM</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Note</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach ($reports as $reportIndex => $report)
                    @foreach ($report->content as $contentIndex => $content)
                        <tr>
                            @if($contentIndex === 0)
                            <td rowspan="{{ count($report->content) }}">{{ $reportIndex + 1 }}</td>
                            <td rowspan="{{ count($report->content) }}">
                                <div class="fw-semibold">{{ $report->equipment?->code }}</div>
                                SN. {{ $report->equipment?->serial_number }}
                            </td>
                            <td rowspan="{{ count($report->content) }}">
                                <div class="fw-semibold">{{ $report->equipment?->brand }}</div>
                                {{ $report->equipment?->model }}
                            </td>
                            <td rowspan="{{ count($report->content) }}">{{ $report->new_hour_meter }}</td>
                            <td rowspan="{{ count($report->content) }}">{{ $report->preventive_maintenance_hour_meter }}</td>
                            @endif
                            <td>{{ $content->part_number ?? '-' }}</td>
                            <td>{{ $content->part_name ?? '-' }}</td>
                            <td>{{ $content->quantity ?? '-' }}</td>
                            <td>{{ $content->unit ?? '-' }}</td>
                            <td>{{ $content->note ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

@endsection
