@extends('layouts.content')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="py-3 mb-0"><a class="text-muted fw-light" href="{{ route('category.index') }}">Kategori Unit /</a> {{ $category->name }}</h4>
    <div>
        @if(auth()->user()->isParent())
        <a href="{{ route('category.rule.create', $category->id) }}" class="btn btn-primary btn-sm text-white fw-medium">+ Aturan Servis</a>
        @endif
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
                    <th>Maksimum Hour Meter</th>
                    <th>Detail Servis</th>
                    @if(auth()->user()->isParent())
                    <th width="15px"></th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($rules as $rule)
                    <tr>
                        <td>{{ $rule->max_value }}</td>
                        <td>{{ $rule->service_plan }}</td>
                        @if(auth()->user()->isParent())
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('category.rule.edit', ['category' => $category->id, 'rule' => $rule->id]) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <form action="{{ route('category.rule.destroy', ['category' => $category->id, 'rule' => $rule->id]) }}" method="post" onsubmit="confirmSubmit(event, this)">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item" type="submit"><i class="bx bx-trash me-1"></i> Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{!! $rules->links() !!}
@endsection
