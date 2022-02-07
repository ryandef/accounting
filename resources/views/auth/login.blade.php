@extends('layouts.auth')
@section('content')
    <div class="card">
        <div class="card-body p-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>Email atau password yang Anda masukkan salah. Silahkan coba lagi.</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">
                        Password
                    </label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
