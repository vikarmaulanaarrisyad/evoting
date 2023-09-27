@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="d-none d-md-flex col-md-6 col-lg-7 bg-image"></div>

            <div class="col-md-6 col-lg-5">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('assets/image/evoting.jpg') }}" alt="" class="w-50 mb-4"
                                        style="margin-left: auto; margin-right: auto;">
                                </a>
                                <h4 class="login-heading text-bold text-center">
                                    {{ $setting->nama_singkatan ?? config('app.name') }}</h4>
                                <h4 class="login-heading text-bold text-center mb-4">PEMILIHAN</h4>
                                <p>{{ $setting->diskripsi_aplikasi ?? '' }}</p>
                                {{-- Form --}}
                                <form action="{{ route('login') }}" method="post">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label for="auth">Username</label>
                                        <input type="text" class="form-control @error('auth') is-invalid @enderror"
                                            id="auth" name="auth" value="{{ old('auth') }}"
                                            placeholder="Masukan username" autocomplete="off">

                                        @error('auth')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" autocomplete="off"
                                            placeholder="Masukan password">

                                        @error('password')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group d-flex justify-content-between align-items-center mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input form-checkbox"
                                                id="customCheck1">
                                            <label for="customCheck1" class="custom-control-label text-muted">show
                                                password</label>
                                        </div>
                                    </div>

                                    <div>
                                        <button class="btn btn-lg btn-primary btn-login mb-2 btn-block">
                                            <i class="fas fa-sign-in-alt"></i> Masuk
                                        </button>
                                    </div>

                                    <div class="mt-3">
                                        <div class="text-muted text-sm">
                                            <p class="text-sm"><strong>NB</strong>: Silahkan hubungi admin jika anda belum
                                                terdaftar sebagai pemilih</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
