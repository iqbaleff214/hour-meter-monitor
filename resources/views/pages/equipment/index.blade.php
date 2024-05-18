@extends('layouts.content')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="py-3 mb-0">Unit Peralatan</h4>
    <div>
        <a href="{{ route('equipment.create') }}" class="btn btn-primary btn-sm text-white fw-medium">+ Unit Peralatan</a>
    </div>
</div>

<div class="mb-2">
    <form action="" method="get">
        <div class="input-group input-group-merge">
            <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
            <input name="q" autocomplete="off" type="search" class="form-control" placeholder="Search..." aria-label="Search..." value="{{ request()->query('q') ?? '' }}" aria-describedby="basic-addon-search31">
        </div>
    </form>
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
                    <th>Pemilik</th>
                    <th width="15px"></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($equipmentAll as $equipment)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $equipment->code }}</div>
                            SN. {{ $equipment->serial_number }}
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $equipment->brand }}</div>
                            {{ $equipment->model }}
                        </td>
                        <td>{{ $equipment->category->name }}</td>
                        <td>{{ $equipment->last_hour_meter }}</td>
                        <td>{{ $equipment->subsidiary?->name ?? '-' }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('equipment.edit', $equipment->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <form action="{{ route('equipment.destroy', $equipment->id) }}" method="post" onsubmit="confirmSubmit(event, this)">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item" type="submit"><i class="bx bx-trash me-1"></i> Hapus</button>
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
