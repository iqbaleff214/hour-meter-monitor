@extends('layouts.content')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="py-3 mb-0">Kategori Unit</h4>
    <div>
        <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm text-white fw-medium">+ Kategori Unit</a>
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
                    <th>Nama Kategori</th>
                    <th>Total Unit Peralatan</th>
                    <th width="15px"></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($categories as $category)
                    <tr>
                        <td>
                            <a href="{{ route('category.rule.index', $category->id) }}">{{ $category->name }}</a>
                        </td>
                        <td>{{ '-' }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('category.edit', $category->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="post" onsubmit="confirmSubmit(event, this)">
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

{!! $categories->links() !!}
@endsection
