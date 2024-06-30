@extends('layouts.content')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="py-3 mb-0"><a class="text-muted fw-light" href="{{ route('category.index') }}">Kategori Unit / </a><a class="text-muted fw-light" href="{{ route('category.rule.index', $category->id) }}">{{ $category->name }} / </a>Baru</h4>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('category.rule.update', ['category' => $category->id, 'rule' => $rule->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $rule->id }}">
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <div class="row">
                <div class="mb-3 col-12 col-md-6">
                    <label class="form-label" for="min_value">Minimum Hour Meter</label>
                    <input type="number" min="0" class="form-control @error('min_value') is-invalid @enderror" name="min_value" id="min_value" value="{{ old('min_value', $rule->min_value) }}">
                    <span class="error invalid-feedback">{{ $errors->first('min_value') }}</span>
                </div>
                <div class="mb-3 col-12 col-md-6">
                    <label class="form-label" for="max_value">Maksimum Hour Meter</label>
                    <input type="number" min="0" class="form-control @error('max_value') is-invalid @enderror" name="max_value" id="max_value" value="{{ old('max_value', $rule->max_value) }}">
                    <span class="error invalid-feedback">{{ $errors->first('max_value') }}</span>
                </div>
            </div>
            @foreach($rule->content as $index => $content)
            <div class="row">
                <div class="mb-3 col-12 col-md-3">
                    <label class="form-label" for="content[part_number][{{ $index }}]">Part Number</label>
                    <input type="text" class="form-control" name="content[part_number][{{ $index }}]" id="content[part_number][{{ $index }}]" required value="{{ $content->part_number }}">
                </div>
                <div class="mb-3 col-12 col-md-3">
                    <label class="form-label" for="content[part_name][{{ $index }}]">Part Name</label>
                    <input type="text" class="form-control" name="content[part_name][{{ $index }}]" id="content[part_name][{{ $index }}]" required value="{{ $content->part_name }}">
                </div>
                <div class="mb-3 col-12 col-md-1">
                    <label class="form-label" for="content[quantity][{{ $index }}]">Qty</label>
                    <input type="number" min="0" class="form-control" name="content[quantity][{{ $index }}]" id="content[quantity][{{ $index }}]" value="{{ $content->quantity }}">
                </div>
                <div class="mb-3 col-12 col-md-2">
                    <label class="form-label" for="content[unit][{{ $index }}]">Unit</label>
                    <input type="text" class="form-control" name="content[unit][{{ $index }}]" id="content[unit][{{ $index }}]" required value="{{ $content->unit }}">
                </div>
                <div class="mb-3 col-12 col-md-3">
                    <label class="form-label" for="content[note][{{ $index }}]">Note</label>
                    <input type="text" class="form-control" name="content[note][{{ $index }}]" id="content[note][{{ $index }}]" value="{{ $content->note }}">
                </div>
            </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
