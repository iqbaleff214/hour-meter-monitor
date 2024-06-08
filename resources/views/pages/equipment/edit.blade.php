@extends('layouts.content')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="py-3 mb-0"><a class="text-muted fw-light" href="{{ route('equipment.index') }}">Unit Peralatan /</a> Edit</h4>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('equipment.update', $equipment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $equipment->id }}">
            <div class="mb-3">
                <label class="form-label" for="code">Kode Unit</label>
                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code', $equipment->code) }}">
                <span class="error invalid-feedback">{{ $errors->first('code') }}</span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="serial_number">Serial Number</label>
                <input type="text" class="form-control @error('serial_number') is-invalid @enderror" name="serial_number" id="serial_number" value="{{ old('serial_number', $equipment->serial_number) }}">
                <span class="error invalid-feedback">{{ $errors->first('serial_number') }}</span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="brand">Brand</label>
                <input
                    type="text"
                    class="form-control @error('brand') is-invalid @enderror"
                    name="brand"
                    @if (count($brands) > 0) list="brand-list" @endif
                    id="brand"
                    value="{{ old('brand', $equipment->brand) }}" />
                @if (count($brands) > 0)
                <datalist id="brand-list">
                    @foreach ($brands as $brand)
                    <option value="{{ $brand }}"></option>
                    @endforeach
                </datalist>
                @endif
                <span class="error invalid-feedback">{{ $errors->first('brand') }}</span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="model">Model</label>
                <input type="text" class="form-control @error('model') is-invalid @enderror" name="model" id="model" value="{{ old('model', $equipment->model) }}">
                <span class="error invalid-feedback">{{ $errors->first('model') }}</span>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori Unit</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                    <option selected disabled></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $equipment->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <span class="error invalid-feedback">{{ $errors->first('category_id') }}</span>
            </div>
            <div class="mb-3">
                <label for="condition" class="form-label">Kondisi</label>
                <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition">
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition->value }}" @selected(old('condition', $equipment->condition) === $condition->value)>{{ strtoupper($condition->value) }}</option>
                    @endforeach
                </select>
                <span class="error invalid-feedback">{{ $errors->first('condition') }}</span>
            </div>
            <div class="mb-3">
                <label for="user_id" class="form-label">Pemilik</label>
                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                    <option selected></option>
                    @foreach ($subsidiaries as $subsidiary)
                        <option value="{{ $subsidiary->id }}" @selected(old('user_id', $equipment->user_id) == $subsidiary->id)>{{ $subsidiary->name }}</option>
                    @endforeach
                </select>
                <span class="error invalid-feedback">{{ $errors->first('user_id') }}</span>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
