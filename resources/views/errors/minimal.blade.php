<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') • {{ config('app.name') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            min-height: 100vh;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .error-card {
            max-width: 720px;
            width: 100%;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 .75rem 2rem rgba(0, 0, 0, .08);
        }

        .error-icon {
            font-size: 5rem;
        }

        .error-code {
            font-size: 5rem;
            font-weight: 800;
            line-height: 1;
        }

        .error-message {
            color: #6c757d;
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="card error-card">

        <div class="card-body text-center p-5">

            <div class="error-icon mb-3">
                @yield('icon')
            </div>

            <div class="error-code text-primary">
                @yield('code')
            </div>

            <h2 class="fw-bold mt-3">
                @yield('heading')
            </h2>

            <p class="error-message mt-3 mb-4">
                @yield('message')
            </p>

            <div class="d-flex justify-content-center gap-2 flex-wrap">

                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i>
                    Go Back
                </a>

                <a href="{{ auth()->check() ? route('admin.applicants.index') : route('applicant.register') }}"
                    class="btn btn-primary rounded-pill px-4">

                    <i class="bi bi-house-door me-1"></i>

                    Home

                </a>

            </div>

        </div>

    </div>

</body>

</html>
