@extends('layouts.guest')

@section('content')
<div class="p-5 shadow bg-white text-dark rounded-md">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-center mb-3">
                <img src="{{ asset('image/icon.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="w-50">
            </div>
            <h3 class="fw-bolder text-center">{{ __('Login') }}</h3>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="row mb-3 justify-content-center">
                <label for="email" class="col-md-3 col-form-label">{{ __('Email') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3 justify-content-center">
                <label for="password" class="col-md-3 col-form-label">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3 justify-content-center">
                <div class="col-12 text-center">
                    <div class="d-flex justify-content-center gap-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-0 justify-content-center">
                <div class="col-12 text-center">
                    <button type="submit" class="btn bg-green-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
