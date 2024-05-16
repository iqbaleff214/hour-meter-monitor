@extends('layouts.app')

@section('body')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Login -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="{{ route('dashboard') }}" class="app-brand-link gap-2">
                <span class="app-brand-logo demo"><img src="{{ asset('PT_EAS.jpg') }}" alt="PT Eshan Agro Sentosa" height="75" srcset=""></span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Welcome to {{ config('app.name') }}! 👋</h4>
            <p class="mb-4">Silakan masuk ke akunmu dan kita lanjutkan perjalanan.</p>

            <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control @error('email') is-invalid @enderror"
                  id="email"
                  name="email"
                  placeholder="Masukkan email"
                  autofocus />
                <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                  <a href="{{ route('password.request') }}">
                    <small>Lupa Password?</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                  <label class="form-check-label" for="remember"> Ingat Saya </label>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
              </div>
            </form>

            {{-- <p class="text-center">
              <span>Belum punya akun?</span>
              <a href="{{ route('register') }}">
                <span>Buat akun</span>
              </a>
            </p> --}}
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
@endpush
