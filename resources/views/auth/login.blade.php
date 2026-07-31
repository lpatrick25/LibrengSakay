@extends('layouts.guest')

@section('title', 'Sign In')

@section('content')
<div class="auth-wrapper min-vh-100 d-flex">

    {{-- Left branding panel (desktop) --}}
    <div class="auth-brand d-none d-lg-flex flex-column justify-content-center align-items-center text-white p-5">
        <div class="auth-brand-inner text-center fade-in">
            <div class="mb-4">
                <i class="bi bi-building display-1"></i>
            </div>
            <h1 class="h2 fw-bold mb-3">Applicant Registration System</h1>
            <p class="lead opacity-75 mb-4 col-lg-10 mx-auto">
                Secure online portal for applicant registration and administration.
            </p>
            <div class="d-flex justify-content-center gap-4 mt-4 opacity-75">
                <div class="text-center">
                    <i class="bi bi-shield-check fs-3 d-block mb-1"></i>
                    <small>Secure</small>
                </div>
                <div class="text-center">
                    <i class="bi bi-file-earmark-person fs-3 d-block mb-1"></i>
                    <small>Registration</small>
                </div>
                <div class="text-center">
                    <i class="bi bi-people fs-3 d-block mb-1"></i>
                    <small>Management</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Right login panel --}}
    <div class="auth-form-panel d-flex flex-column justify-content-center align-items-center p-4 p-md-5 flex-grow-1">
        <div class="auth-card-wrap w-100 fade-in" style="max-width: 420px;">

            {{-- Mobile logo --}}
            <div class="text-center mb-4 d-lg-none">
                <i class="bi bi-building text-primary" style="font-size: 2.5rem;"></i>
                <h2 class="h5 fw-bold mt-2 mb-0">Abuyog Community College</h2>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="d-none d-lg-block mb-3">
                            <i class="bi bi-building text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <h1 class="h4 fw-bold mb-1">Sign in to your account</h1>
                        <p class="text-muted small mb-0">Enter your credentials below to continue.</p>
                    </div>

                    {{-- Flash status (e.g. after logout) --}}
                    @if (session('status'))
                        <div class="alert alert-success border-0 rounded-3 small mb-3" role="alert">
                            <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
                        </div>
                    @endif

                    <form id="login-form" novalidate>
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email"
                                       class="form-control border-start-0 rounded-end-3"
                                       id="email"
                                       name="email"
                                       placeholder="name@example.com"
                                       autocomplete="email"
                                       autofocus
                                       value="{{ old('email') }}">
                            </div>
                            <div class="invalid-feedback d-block" data-error="email"></div>
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password"
                                       class="form-control border-start-0 border-end-0"
                                       id="password"
                                       name="password"
                                       placeholder="Enter your password"
                                       autocomplete="current-password">
                                <button type="button"
                                        class="btn btn-outline-secondary border-start-0 rounded-end-3 toggle-password"
                                        data-target="#password"
                                        tabindex="-1"
                                        aria-label="Show password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback d-block" data-error="password"></div>
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                <label class="form-check-label small" for="remember">Remember Me</label>
                            </div>
                            <span class="small text-muted" title="Coming soon">
                                Forgot password? <span class="text-decoration-underline">Coming Soon</span>
                            </span>
                        </div>

                        {{-- Auth error (generic) --}}
                        <div id="auth-error" class="alert alert-danger border-0 rounded-3 small d-none mb-3" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            <span id="auth-error-text"></span>
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button type="submit" id="btn-login" class="btn btn-primary btn-lg rounded-pill">
                                <span class="btn-text">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                                </span>
                                <span class="btn-spinner d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Signing in…
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center text-muted small mt-4 mb-0">
                &copy; {{ date('Y') }} Abuyog Community College
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.LoginRoutes = {
        login: @json(route('login.submit')),
    };
</script>
<script src="{{ asset('js/auth-login.js') }}"></script>
@endpush
