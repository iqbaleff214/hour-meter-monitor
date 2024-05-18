@extends('layouts.content')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="py-3 mb-0"><a class="text-muted fw-light" href="{{ route('subsidiary.index') }}">Anak Perusahaan /</a> Baru</h4>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('subsidiary.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">Nama Perusahaan</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
                <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="code">Kode Perusahaan</label>
                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}">
                <span class="error invalid-feedback">{{ $errors->first('code') }}</span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="phone">Telepon</label>
                <input type="text" id="phone" class="form-control phone-mask @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                <span class="error invalid-feedback">{{ $errors->first('phone') }}</span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="address">Alamat</label>
                <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
                <span class="error invalid-feedback">{{ $errors->first('address') }}</span>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
