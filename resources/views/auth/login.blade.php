@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<div class="auth-card">
    <div style="text-align:center; margin-bottom:35px;">
        <div class="auth-logo">
            <div class="auth-logo-icon"><i class="fas fa-coffee"></i></div>
            <div class="auth-logo-text">CafePOS</div>
        </div>
        <p style="color:var(--neutral-light); margin-top:10px;">Masuk ke sistem kasir</p>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        {{ $errors->first() }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-user"></i> Username
            </label>
            <input type="text"
                   name="username"
                   class="form-control"
                   value="{{ old('username') }}"
                   placeholder="Masukkan username"
                   required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-lock"></i> Password
            </label>
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Masukkan password"
                   required>
        </div>

        <button type="submit" class="action-btn action-btn-primary" style="width:100%; justify-content:center; padding:15px; font-size:16px; margin-top:10px;">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>

        <div style="text-align:center; margin-top:20px; color:var(--neutral-light); font-size:14px;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:var(--gold-main); font-weight:600;">Daftar di sini</a>
        </div>
    </form>
</div>
@endsection