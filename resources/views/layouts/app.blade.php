<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Libreng Sakay Online Registration') | Municipality of Abuyog</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/abuyog-logo.png') }}">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Bootstrap Table --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/applicant-registration.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant-management.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-management.css') }}">
    <link rel="stylesheet" href="{{ asset('css/email-templates.css') }}">

    @stack('styles')

</head>

<body>

    {{-- ========================================================= --}}
    {{-- HERO HEADER --}}
    {{-- ========================================================= --}}

    <header class="hero-banner">

        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">

                {{-- Brand --}}
                <a class="navbar-brand d-flex align-items-center gap-3"
                    href="{{ auth()->check() ? route('admin.applicants.index') : route('applicant.register') }}">

                    <img src="{{ asset('images/abuyog-logo.png') }}" class="hero-logo" alt="Municipality of Abuyog">

                    <div>
                        <div class="fw-bold fs-5">
                            Municipality of Abuyog
                        </div>
                        <small class="text-white-50">
                            Province of Leyte
                        </small>
                    </div>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar">

                    {{-- Left Menu --}}
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        {{-- Admin Only --}}
                        @auth

                            {{-- Public Registration --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('applicant.register') ? 'active' : '' }}"
                                    href="{{ route('applicant.register') }}">
                                    <i class="bi bi-person-plus-fill me-1"></i>
                                    Registration
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.applicants.*') ? 'active' : '' }}"
                                    href="{{ route('admin.applicants.index') }}">
                                    <i class="bi bi-clipboard-data-fill me-1"></i>
                                    Applicants
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                                    href="{{ route('admin.users.index') }}">
                                    <i class="bi bi-person-gear me-1"></i>
                                    Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.email-templates.*') ? 'active' : '' }}"
                                    href="{{ route('admin.email-templates.index') }}">
                                    <i class="bi bi-envelope-paper me-1"></i> Email Templates
                                </a>
                            </li>

                        @endauth

                    </ul>

                    {{-- Right Menu --}}
                    <ul class="navbar-nav ms-auto align-items-lg-center">

                        @guest

                            {{-- <li class="nav-item">
                                <a class="btn btn-warning rounded-pill px-4" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Administrator Login
                                </a>
                            </li> --}}
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <div class="hex-icon-sm bg-warning text-dark">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div class="text-start d-none d-lg-block">
                                        <div class="fw-semibold lh-1">
                                            {{ auth()->user()->name }}
                                        </div>
                                        <small class="text-white-50">
                                            Administrator
                                        </small>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">
                                    <li class="px-3 py-2">
                                        <div class="fw-semibold">
                                            {{ auth()->user()->name }}
                                        </div>
                                        <small class="text-muted">
                                            {{ auth()->user()->email }}
                                        </small>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.applicants.index') }}">
                                            <i class="bi bi-clipboard-data me-2"></i>
                                            Applicant Management
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                            <i class="bi bi-person-gear me-2"></i>
                                            User Management
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.email-templates.index') }}">
                                            <i class="bi bi-person-gear me-2"></i>
                                            Email Templates
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf

                                            <button type="submit" class="dropdown-item text-danger">

                                                <i class="bi bi-box-arrow-right me-2"></i>
                                                Sign Out
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- HERO CONTENT --}}
        @unless (request()->routeIs('admin.*'))
            <div class="hero-content">

                <div class="container py-5">

                    <div class="row justify-content-center">

                        <div class="col-lg-10 text-center">

                            <span class="badge rounded-pill bg-warning text-dark px-4 py-2 mb-4 shadow">

                                <i class="bi bi-bus-front-fill me-2"></i>

                                Civil Service Commission Pen-and-Paper Test

                            </span>

                            <h1 class="display-5 fw-bold mb-3">

                                Libreng Sakay Online Registration

                            </h1>

                            <p class="lead mb-2">

                                Official online registration portal of the

                                <strong>Municipality of Abuyog</strong>

                                for CSC Pen-and-Paper Test (PPT) examinees.

                            </p>

                            <p class="text-white-50">

                                Register online to avail transportation assistance under the
                                <strong>Libreng Sakay Online Registration.</strong>

                            </p>

                        </div>

                    </div>

                </div>

            </div>
        @endunless

    </header>

    {{-- ========================================================= --}}
    {{-- MAIN --}}
    {{-- ========================================================= --}}

    <main class="py-5">

        <div class="@yield('container-class', 'container')">

            @yield('content')

        </div>

    </main>

    {{-- ========================================================= --}}
    {{-- FOOTER --}}
    {{-- ========================================================= --}}

    <footer class="border-top">

        <div class="container py-4">

            <div class="row align-items-center gy-3">

                <div class="col-md-6">

                    <div class="d-flex align-items-center gap-3">

                        <img src="{{ asset('images/abuyog-logo.png') }}" width="55"
                            class="rounded-circle bg-white shadow p-1">

                        <div>

                            <div class="fw-semibold">

                                Municipality of Abuyog

                            </div>

                            <small class="text-muted">

                                Province of Leyte

                            </small>

                        </div>

                    </div>

                </div>

                <div class="col-md-6 text-md-end">

                    <div class="fw-semibold">

                        Libreng Sakay Online Registration

                    </div>

                    <small class="text-muted">

                        Civil Service Commission Pen-and-Paper Test (CSC-PPT)

                    </small>

                </div>

            </div>

            <hr>

            <div class="d-flex flex-column flex-md-row justify-content-between small text-muted">

                <div>

                    © {{ date('Y') }}
                    Municipality of Abuyog.
                    All Rights Reserved.

                </div>

                <div>

                    Republic Act No. 10173 • Data Privacy Act of 2012

                </div>

            </div>

        </div>

    </footer>

    {{-- Scripts --}}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/export/bootstrap-table-export.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/print/bootstrap-table-print.min.js">
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/fslightbox/index.js"></script>

    <script src="{{ asset('js/applicant-registration.js') }}"></script>

    @stack('scripts')

</body>

</html>
