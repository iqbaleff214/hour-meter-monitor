@extends('layouts.content')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="py-3 mb-0">Hour Meter</h4>
        <div>
            @if($submitted)
                <a href="{{ route('report.hour-meter.create') }}" class="btn btn-primary btn-sm text-white fw-medium">+
                    Hour Meter</a>
            @endif
        </div>
    </div>
    <div id="request-value" data-request="{{ json_encode((object) request()->query()) }}"></div>

    @if(auth()->user()->isParent())
        <div class="row mb-2">
            <div class="col-12 col-md-4">
                <form action="" method="get">
                    <div class="input-group input-group-merge mb-2">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input name="q" autocomplete="off" type="search" class="form-control" placeholder="Search..."
                               aria-label="Search..." value="{{ request()->query('q') ?? '' }}"
                               aria-describedby="basic-addon-search31">
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-4">
                <div class="mb-2">
                    <input type="date" class="form-control" id="date" aria-label="Pilih tanggal"
                           max="{{ date('Y-m-d') }}"
                           value="{{ request()->query('date') }}">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="mb-2">
                    <select class="form-select" id="subsidiary" aria-label="Pilih pelapor">
                        <option value="">Semua Pelapor</option>
                        @foreach($subsidiaries as $subsidiary)
                            <option
                                value="{{ $subsidiary->id }}" @selected(request()->query('subsidiary') == $subsidiary->id)>{{ $subsidiary->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    @else
        <div class="row mb-2">
            <div class="col-12 col-md-6">
                <form action="" method="get">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input name="q" autocomplete="off" type="search" class="form-control" placeholder="Search..."
                               aria-label="Search..." value="{{ request()->query('q') ?? '' }}"
                               aria-describedby="basic-addon-search31">
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-2">
                    <input type="date" class="form-control" id="date" aria-label="Pilih tanggal"
                           max="{{ date('Y-m-d') }}"
                           value="{{ request()->query('date') }}">
                </div>
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Tanggal</th>
                    @if(auth()->user()->isParent())
                        <th>Pelapor</th>
                    @endif
                    <th>Jumlah Unit Peralatan</th>
                    <th width="15px"></th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach ($reports as $report)
                    <tr>
                        <td class="fw-semibold">
                            <a href="{{ route('report.hour-meter.show', $report->id) }}">{{ $report->created_at->isoFormat('Y-MM-DD') }}</a>
                        </td>
                        @if(auth()->user()->isParent())
                            <td>{{ $report->subsidiary?->name ?? '-' }}</td>
                        @endif
                        <td>{{ count($report->details) }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('report.hour-meter.export', $report->id) }}"
                                       download="{{ $report->created_at->isoFormat('Y-MM-DD') . '_' . $report->subsidiary?->name . '.csv' }}"><i
                                            class="bx bx-download me-1"></i> Export CSV</a>
                                    <form action="{{ route('report.hour-meter.destroy', $report->id) }}" method="post"
                                          onsubmit="confirmSubmit(event, this)">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item" type="submit"><i class="bx bx-trash me-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! $reports->links() !!}
@endsection

@push('script')
    <script>
        const baseUrl = new URL(window.location.href);
        const queries = JSON.parse(document.getElementById('request-value').dataset.request);

        Object.keys(queries).forEach((k) => queries[k] == null && delete queries[k]);

        const subsidiarySelectElement = document.getElementById('subsidiary');
        if (subsidiarySelectElement) {
            subsidiarySelectElement.onchange = function (e) {
                queries.subsidiary = e.target.value;
                baseUrl.search = new URLSearchParams(queries).toString();
                location.href = baseUrl.href;
            }
        }

        document.getElementById('date').onchange = function (e) {
            queries.date = e.target.value;
            baseUrl.search = new URLSearchParams(queries).toString();
            location.href = baseUrl.href;
        }
    </script>
@endpush
