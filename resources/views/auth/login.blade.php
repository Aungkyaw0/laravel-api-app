@extends('layouts.app')

@section('title', 'Login - Meals on Wheels')

@section('styles')
<style>
    .login-section {
        min-height: 100vh;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset("img/login-hero.png") }}');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-header img {
        width: 120px;
        margin-bottom: 1rem;
    }

    .form-control {
        border-radius: 8px;
        padding: 0.8rem 1.2rem;
        border: 1px solid #ddd;
        margin-bottom: 1rem;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.25);
    }

    .btn-login {
        width: 100%;
        padding: 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 1rem;
    }

    .divider {
        text-align: center;
        margin: 1.5rem 0;
        position: relative;
    }

    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 45%;
        height: 1px;
        background-color: #ddd;
    }

    .divider::before { left: 0; }
    .divider::after { right: 0; }

    .social-login {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .social-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .social-btn:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
</style>
@endsection

@section('content')
<section class="login-section mt-5 pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <div class="login-header">
                        <img src="{{ asset('img/logo.png') }}" alt="Meals on Wheels Logo">
                        <h2>Welcome Back</h2>
                        <p class="text-muted">Sign in to continue to your account</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="Email Address" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-login">Sign In</button>
                    </form>

                    <div class="divider">or</div>

                    <div class="social-login">
                        <a href="#" class="social-btn"><i class="fab fa-google"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                    </div>

                    <p class="text-center mb-0">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-primary">Sign Up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 