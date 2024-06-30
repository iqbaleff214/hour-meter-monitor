@extends('layouts.content')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="py-3 mb-0">Unit Peralatan</h4>
        <div>
            @if(auth()->user()->isParent())
                <a href="{{ route('equipment.create') }}" class="btn btn-primary btn-sm text-white fw-medium">
                    + UnitPeralatan
                </a>
            @endif
        </div>
    </div>
    <div id="request-value" data-request="{{ json_encode((object) request()->query()) }}"></div>

    <div class="mb-2">
        <form action="" method="get">
            <div class="input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                <input name="q" autocomplete="off" type="search" class="form-control" placeholder="Search..."
                       aria-label="Search..." value="{{ request()->query('q') ?? '' }}"
                       aria-describedby="basic-addon-search31">
            </div>
        </form>
    </div>
    @if(auth()->user()->isParent())
        <div class="row mb-2">
            <div class="col-12 col-md-4">
                <div class="mb-2">
                    <select class="form-select" id="brand" aria-label="Pilih brand">
                        <option value="">Semua Brand</option>
                        @foreach($brands as $id => $brand)
                            <option
                                value="{{ $brand }}" @selected(request()->query('brand') == $brand)>{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="mb-2">
                    <select class="form-select" id="category" aria-label="Pilih kategori">
                        <option value="">Semua Kategori Unit</option>
                        @foreach($categories as $id => $category)
                            <option
                                value="{{ $id }}" @selected(request()->query('category') == $id)>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="mb-2">
                    <select class="form-select" id="subsidiary" aria-label="Pilih pelapor">
                        <option value="">Semua Pemilik</option>
                        @foreach($subsidiaries as $id => $subsidiary)
                            <option
                                value="{{ $id }}" @selected(request()->query('subsidiary') == $id)>{{ $subsidiary }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    @else
        <div class="row mb-2">
            <div class="col-12 col-md-6">
                <div class="mb-2">
                    <select class="form-select" id="brand" aria-label="Pilih brand">
                        <option value="">Semua Brand</option>
                        @foreach($brands as $id => $brand)
                            <option
                                value="{{ $brand }}" @selected(request()->query('brand') == $brand)>{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-2">
                    <select class="form-select" id="category" aria-label="Pilih kategori">
                        <option value="">Semua Kategori Unit</option>
                        @foreach($categories as $id => $category)
                            <option
                                value="{{ $id }}" @selected(request()->query('category') == $id)>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Kode Unit</th>
                    <th>Model</th>
                    <th>Kategori Unit</th>
                    <th>Hour Meter</th>
                    @if(auth()->user()->isParent())
                        <th>Pemilik</th>
                    @endif
                    <th width="15px"></th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach ($equipmentAll as $equipment)
                    <tr>
                        <td>
                            <a href="{{ route('equipment.show', $equipment) }}" class="fw-semibold d-block">{{ $equipment->code }}</a>
                            SN. {{ $equipment->serial_number }}
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $equipment->brand }}</div>
                            {{ $equipment->model }}
                        </td>
                        <td>{{ $equipment->category->name }}</td>
                        <td>{{ $equipment->last_hour_meter }}</td>
                        @if(auth()->user()->isParent())
                            <td>{{ $equipment->subsidiary?->name ?? '-' }}</td>
                        @endif
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('equipment.edit', $equipment->id) }}"><i
                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <form action="{{ route('equipment.destroy', $equipment->id) }}" method="post"
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

    {!! $equipmentAll->links() !!}
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

        document.getElementById('category').onchange = function (e) {
            queries.category = e.target.value;
            baseUrl.search = new URLSearchParams(queries).toString();
            location.href = baseUrl.href;
        }

        document.getElementById('brand').onchange = function (e) {
            queries.brand = e.target.value;
            baseUrl.search = new URLSearchParams(queries).toString();
            location.href = baseUrl.href;
        }

        document.getElementById('condition').onchange = function (e) {
            queries.condition = e.target.value;
            baseUrl.search = new URLSearchParams(queries).toString();
            location.href = baseUrl.href;
        }
    </script>
@endpush
