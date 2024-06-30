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
            <input type="hidden" name="service_plan" value="content">
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
            <div class="d-flex justify-content-between">
                <label for="" class="form-label">Detail Servis</label>
                <a class="cursor-pointer" href="#" id="add-detail-service">
                    + Detail Servis
                </a>
            </div>
            <div id="detail-service-wrapper">
            </div>
            <button type="submit" class="btn btn-primary" disabled>Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    const serviceWrapper = document.getElementById('detail-service-wrapper');

    let countService = 0;

    $('#add-detail-service').on('click', function(e) {
        if (countService === 0) {
            $('button[type="submit"]').prop('disabled', false);
        }

        serviceWrapper.innerHTML += `<div class="row">
                <div class="mb-3 col-12 col-md-3">
                    <label class="form-label" for="content[part_number][${countService}]">Part Number</label>
                    <input type="text" class="form-control" name="content[part_number][${countService}]" id="content[part_number][${countService}]" required>
                </div>
                <div class="mb-3 col-12 col-md-3">
                    <label class="form-label" for="content[part_name][${countService}]">Part Name</label>
                    <input type="text" class="form-control" name="content[part_name][${countService}]" id="content[part_name][${countService}]" required>
                </div>
                <div class="mb-3 col-12 col-md-1">
                    <label class="form-label" for="content[quantity][${countService}]">Qty</label>
                    <input type="number" min="0" class="form-control" name="content[quantity][${countService}]" id="content[quantity][${countService}]" value="0">
                </div>
                <div class="mb-3 col-12 col-md-2">
                    <label class="form-label" for="content[unit][${countService}]">Unit</label>
                    <input type="text" class="form-control" name="content[unit][${countService}]" id="content[unit][${countService}]" required>
                </div>
                <div class="mb-3 col-12 col-md-3">
                    <label class="form-label" for="content[note][${countService}]">Note</label>
                    <input type="text" class="form-control" name="content[note][${countService}]" id="content[note][${countService}]">
                </div>
            </div>`;
        countService++;
    });
</script>
@endpush
