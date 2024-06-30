@extends('layouts.content')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="py-3 mb-0"><a class="text-muted fw-light" href="{{ route('category.index') }}">Kategori Unit / </a><a class="text-muted fw-light" href="{{ route('category.rule.index', $category->id) }}">{{ $category->name }} / </a>Baru</h4>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('category.rule.store', $category->id) }}" method="POST">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <div class="row">
                <div class="mb-3 col-12 col-md-6">
                    <label class="form-label" for="min_value">Minimum Hour Meter</label>
                    <input type="number" min="0" class="form-control @error('min_value') is-invalid @enderror" name="min_value" id="min_value" value="{{ old('min_value', 0) }}">
                    <span class="error invalid-feedback">{{ $errors->first('min_value') }}</span>
                </div>
                <div class="mb-3 col-12 col-md-6">
                    <label class="form-label" for="max_value">Maksimum Hour Meter</label>
                    <input type="number" min="0" class="form-control @error('max_value') is-invalid @enderror" name="max_value" id="max_value" value="{{ old('max_value', 0) }}">
                    <span class="error invalid-feedback">{{ $errors->first('max_value') }}</span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="service_plan">Detail Servis</label>
                <input type="text" class="form-control @error('service_plan') is-invalid @enderror" name="service_plan" id="service_plan" value="{{ old('service_plan') }}">
                <span class="error invalid-feedback">{{ $errors->first('service_plan') }}</span>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
