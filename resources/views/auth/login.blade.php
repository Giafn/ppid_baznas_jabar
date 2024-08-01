@extends('layouts.guest')

@section('content')
<main class="form-signin">
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="d-flex justify-content-center mb-3">
        <img src="/image/icon.png" alt="logo" width="100">
      </div>
      <h1 class="h3 mb-3 fw-normal text-center">Masuk Dashboard</h1>
  
      <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}" name="email" required>
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>
  
      <div class="mb-3 text-center">
        @error('email')
            <strong class="text-danger">{{ ucfirst($message) }}</strong>
        @enderror
        @error('password')
            <strong class="text-danger">{{ ucfirst($message) }}</strong>
        @enderror
      </div>
      <button class="w-100 btn btn-lg bg-green-primary" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted text-center">&copy; PPID Baznas Jabar {{ date('Y') }}</p>
    </form>
  </main>
@endsection
