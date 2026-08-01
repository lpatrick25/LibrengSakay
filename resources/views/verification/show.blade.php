@extends('layouts.guest')

@section('title', 'Registration Verification')

@section('content')

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-xl-8 col-lg-9">

                {{-- Header --}}
                <div class="text-center mb-4">

                    <img src="{{ asset('images/abuyog-logo.png') }}" alt="Municipality of Abuyog" style="height:90px;"
                        class="mb-3">

                    <h1 class="fw-bold mb-2">
                        Applicant Registration Verification
                    </h1>

                    <p class="text-muted mb-0">
                        Municipality of Abuyog • Province of Leyte
                    </p>

                </div>

                {{-- Status Card --}}
                <div class="card border-0 shadow rounded-4 overflow-hidden">

                    <div class="card-header bg-success text-white text-center py-4">

                        <i class="bi bi-patch-check-fill display-2 d-block mb-2"></i>

                        <h2 class="fw-bold mb-1">
                            Registration Verified
                        </h2>

                        <p class="mb-0 opacity-75">
                            This applicant has been officially verified.
                        </p>

                    </div>

                    <div class="card-body p-4 p-lg-5">

                        <div class="text-center mb-4">

                            <h3 class="fw-bold mb-1">
                                {{ $applicant->full_name }}
                            </h3>

                            <span class="badge bg-success rounded-pill px-3 py-2">
                                VERIFIED
                            </span>

                        </div>

                        <hr>

                        <div class="row g-4">

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Reference Number
                                </small>

                                <div class="fw-semibold">
                                    #{{ str_pad($applicant->id, 6, '0', STR_PAD_LEFT) }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Applicant Category
                                </small>

                                <div class="fw-semibold">
                                    {{ $applicant->applicant_type_label }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Place of Examination
                                </small>

                                <div class="fw-semibold">
                                    {{ $applicant->place_of_examination }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Verification Status
                                </small>

                                <span class="badge bg-success">
                                    {{ $applicant->verification_status_label }}
                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Verified By
                                </small>

                                <div class="fw-semibold">
                                    {{ $applicant->verified_by }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Verified On
                                </small>

                                <div class="fw-semibold">
                                    {{ optional($applicant->verified_at)->format('F d, Y h:i A') }}
                                </div>

                            </div>

                            @if ($applicant->remarks)
                                <div class="col-12">

                                    <small class="text-muted d-block">
                                        Remarks
                                    </small>

                                    <div class="fw-semibold">
                                        {{ $applicant->remarks }}
                                    </div>

                                </div>
                            @endif

                        </div>

                        <div class="alert alert-success border-0 rounded-4 mt-5">

                            <div class="d-flex">

                                <div class="me-3">

                                    <i class="bi bi-shield-check fs-2"></i>

                                </div>

                                <div>

                                    <h6 class="fw-bold mb-2">
                                        Verification Successful
                                    </h6>

                                    <p class="mb-0">

                                        This QR Code has been validated successfully.

                                        The applicant's registration is authentic and
                                        has been officially approved by the Municipality
                                        of Abuyog.

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-footer bg-light border-0 py-3">

                        <div class="row align-items-center">

                            <div class="col-md">

                                <small class="text-muted">

                                    Verification UUID

                                    <br>

                                    <code>{{ $applicant->verification_uuid }}</code>

                                </small>

                            </div>

                            <div class="col-md-auto mt-3 mt-md-0">

                                <button onclick="window.print()" class="btn btn-primary rounded-pill px-4">

                                    <i class="bi bi-printer me-2"></i>

                                    Print

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="text-center mt-4">

                    <small class="text-muted">

                        &copy; {{ date('Y') }}

                        Municipality of Abuyog

                        <br>

                        Applicant Registration System

                    </small>

                </div>

            </div>

        </div>

    </div>

@endsection
