@extends('layouts.guest')

@section('title', 'Sign In')

@section('content')
    <div class="auth-wrapper d-flex min-vh-100">

        {{-- ===========================================================
        Left Branding Panel (Desktop)
    ============================================================ --}}
        <div class="auth-brand d-none d-lg-flex flex-column justify-content-center align-items-center text-white p-5">
            <div class="auth-brand-inner text-center fade-in">

                <img src="{{ asset('images/abuyog-logo.png') }}" alt="Municipality of Abuyog" class="mb-4"
                    style="width:110px;height:110px;object-fit:contain;">

                <h1 class="display-6 fw-bold mb-3">
                    Applicant Registration System
                </h1>

                <p class="lead opacity-75 mb-5">
                    Municipality of Abuyog, Leyte
                </p>

                <div class="row text-center g-4 mt-2">

                    <div class="col">
                        <i class="bi bi-shield-check fs-1 mb-2 d-block"></i>
                        <div class="fw-semibold">Secure</div>
                        <small class="opacity-75">
                            Protected access
                        </small>
                    </div>

                    <div class="col">
                        <i class="bi bi-person-vcard fs-1 mb-2 d-block"></i>
                        <div class="fw-semibold">Applicants</div>
                        <small class="opacity-75">
                            Registration Portal
                        </small>
                    </div>

                    <div class="col">
                        <i class="bi bi-gear fs-1 mb-2 d-block"></i>
                        <div class="fw-semibold">Administration</div>
                        <small class="opacity-75">
                            System Management
                        </small>
                    </div>

                </div>

                <hr class="border-light opacity-25 my-5">

                <small class="opacity-75">
                    Secure Applicant Registration and Verification Platform
                </small>

            </div>
        </div>

        {{-- ===========================================================
        Login Panel
    ============================================================ --}}
        <div class="auth-form-panel d-flex align-items-center justify-content-center flex-grow-1 p-4 p-lg-5">

            <div class="auth-card-wrap w-100 fade-in" style="max-width:440px;">

                {{-- Mobile Header --}}
                <div class="text-center d-lg-none mb-4">

                    <img src="{{ asset('images/abuyog-logo.png') }}" class="mb-3"
                        style="width:72px;height:72px;object-fit:contain;" alt="Logo">

                    <h2 class="h5 fw-bold mb-1">
                        Applicant Registration
                    </h2>

                    <div class="text-muted small">
                        Municipality of Abuyog
                    </div>

                </div>

                <div class="card border-0 shadow rounded-4">

                    <div class="card-body p-4 p-lg-5">

                        <div class="text-center mb-4">

                            <div class="d-none d-lg-block mb-3">
                                <img src="{{ asset('images/abuyog-logo.png') }}" style="width:70px;height:70px;"
                                    alt="Logo">
                            </div>

                            <h1 class="fw-bold h3 mb-2">
                                Welcome Back
                            </h1>

                            <p class="text-muted mb-0">
                                Sign in to continue to the administration panel.
                            </p>

                        </div>

                        @if (session('status'))
                            <div class="alert alert-success rounded-3 border-0">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('status') }}
                            </div>
                        @endif

                        <form id="login-form" novalidate>

                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Email Address
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-envelope"></i>
                                    </span>

                                    <input type="email" class="form-control" id="email" name="email"
                                        autocomplete="username" autofocus placeholder="name@example.com">

                                </div>

                                <div class="invalid-feedback d-block" data-error="email"></div>

                            </div>

                            {{-- Password --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-lock"></i>
                                    </span>

                                    <input type="password" class="form-control border-start-0 border-end-0" id="password"
                                        name="password" autocomplete="current-password" placeholder="Enter your password">

                                    <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="#password">

                                        <i class="bi bi-eye"></i>

                                    </button>

                                </div>

                                <div id="caps-lock-warning" class="small text-warning mt-2 d-none">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Caps Lock is on.
                                </div>

                                <div class="invalid-feedback d-block" data-error="password"></div>

                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div class="form-check">

                                    <input class="form-check-input" id="remember" name="remember" type="checkbox">

                                    <label class="form-check-label small" for="remember">

                                        Remember Me

                                    </label>

                                </div>

                                <small class="text-muted">
                                    Forgot Password?
                                </small>

                            </div>

                            <div id="auth-error" class="alert alert-danger rounded-3 border-0 d-none">

                                <i class="bi bi-exclamation-circle me-2"></i>

                                <span id="auth-error-text"></span>

                            </div>

                            <div class="d-grid">

                                <button id="btn-login" class="btn btn-primary btn-lg rounded-pill">

                                    <span class="btn-text">

                                        <i class="bi bi-box-arrow-in-right me-2"></i>

                                        Sign In

                                    </span>

                                    <span class="btn-spinner d-none">

                                        <span class="spinner-border spinner-border-sm me-2"></span>

                                        Signing in...

                                    </span>

                                </button>

                            </div>

                        </form>

                        <hr class="my-4">

                        <div class="text-center">

                            <a href="{{ route('applicant.register') }}" class="text-decoration-none small">

                                <i class="bi bi-arrow-left me-1"></i>

                                Back to Applicant Registration

                            </a>

                        </div>

                    </div>

                </div>

                <div class="text-center mt-4 small text-muted">

                    <div>
                        &copy; {{ date('Y') }}
                        Municipality of Abuyog, Leyte
                    </div>

                    <div class="mt-1">
                        Applicant Registration System
                    </div>

                </div>

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
