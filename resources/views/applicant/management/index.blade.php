@extends('layouts.app')

@section('title', 'Applicant Management')
@section('container-class', 'container-fluid px-3 px-lg-4')

@section('content')

    {{-- ======================================================================
    Page Header
====================================================================== --}}
    <div class="card border-0 shadow-sm rounded-4 hero-card mb-4 fade-in">
        <div class="card-body p-4">

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">

                {{-- Left --}}
                <div class="d-flex align-items-center gap-3">

                    <div class="hero-icon">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>

                    <div>

                        <small class="text-uppercase fw-semibold text-warning d-block mb-1">
                            Municipality of Abuyog • LIBRENG SAKAY ni Mayor Lemy
                        </small>

                        <h1 class="h3 fw-bold mb-2">
                            CSC Examination Applicant Management
                        </h1>

                        <p class="text-muted mb-0">
                            Manage, review, verify, and monitor applicants registered for the
                            <strong>Libreng Sakay for the Civil Service Commission Pen & Paper Examination.</strong>
                        </p>

                    </div>

                </div>

                {{-- Right --}}
                <div class="d-flex flex-wrap justify-content-lg-end gap-2">

                    <button type="button" id="btn-refresh-all" class="btn btn-outline-warning rounded-pill">

                        <i class="bi bi-arrow-clockwise me-2"></i>

                        Refresh

                    </button>

                    <div class="btn-group">

                        <button type="button" class="btn btn-outline-warning rounded-start-pill dropdown-toggle"
                            data-bs-toggle="dropdown">

                            <i class="bi bi-download me-2"></i>

                            Export

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">

                            <li>
                                <a class="dropdown-item" href="#" id="btn-export-csv">
                                    <i class="bi bi-filetype-csv me-2 text-success"></i>
                                    CSV
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#" id="btn-export-excel">
                                    <i class="bi bi-file-earmark-excel me-2 text-success"></i>
                                    Excel
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#" id="btn-export-pdf">
                                    <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                                    PDF
                                </a>
                            </li>

                        </ul>

                    </div>

                    <button id="btn-print-table" class="btn btn-outline-warning rounded-pill">

                        <i class="bi bi-printer me-2"></i>

                        Print

                    </button>

                    <a href="{{ route('applicant.register') }}" class="btn btn-warning rounded-pill fw-semibold px-4">

                        <i class="bi bi-person-plus-fill me-2"></i>

                        New Application

                    </a>

                </div>

            </div>

        </div>
    </div>

    {{-- ── Statistics Cards ────────────────────────────────────────────────── --}}
    <div id="stats-skeleton" class="row g-4 mb-4">
        @for ($i = 0; $i < 7; $i++)
            <div class="col-6 col-lg-4 col-xl">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="skeleton skeleton-text mb-3" style="width:120px;height:14px;"></div>
                                <div class="skeleton skeleton-text" style="width:80px;height:42px;"></div>
                            </div>
                            <div class="skeleton skeleton-circle" style="width:58px;height:58px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <div id="stats-cards" class="row g-3 mb-4 d-none">
        @include('applicant.management.partials.stats-cards')
    </div>

    {{-- ==========================================================================
    Filter Panel
========================================================================== --}}
    <div class="card filter-card border-0 shadow-sm rounded-4 mb-4 fade-in">

        <div class="card-header bg-transparent border-0 py-3 px-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h2 class="h5 fw-bold mb-1">
                        <i class="bi bi-funnel-fill text-warning me-2"></i>
                        Filter Applicants
                    </h2>

                    <small class="text-muted">
                        Narrow down the applicant list using the filters below.
                    </small>

                </div>

                <button id="btn-reset-filters" class="btn btn-outline-warning btn-sm rounded-pill">

                    <i class="bi bi-arrow-counterclockwise me-1"></i>

                    Reset

                </button>

            </div>

        </div>

        <div class="card-body pt-0 px-4 pb-4">

            <div class="row g-3">

                {{-- Category --}}
                <div class="col-md-6 col-lg-3">

                    <label class="form-label fw-semibold small">
                        <i class="bi bi-people-fill me-1 text-warning"></i>
                        Applicant Category
                    </label>

                    <select id="filter-type" class="form-select rounded-3">

                        <option value="">All Categories</option>
                        <option value="abuyognon">Abuyognon</option>
                        <option value="acc_student">ACC Student</option>
                        <option value="non_abuyognon">Non-Abuyognon</option>

                    </select>

                </div>

                {{-- Verification --}}
                <div class="col-md-6 col-lg-3">

                    <label class="form-label fw-semibold small">
                        <i class="bi bi-patch-check-fill me-1 text-warning"></i>
                        Verification
                    </label>

                    <select id="filter-status" class="form-select rounded-3">

                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="verified">Verified</option>
                        <option value="rejected">Rejected</option>

                    </select>

                </div>

                {{-- ID --}}
                <div class="col-md-6 col-lg-3">

                    <label class="form-label fw-semibold small">
                        <i class="bi bi-person-vcard-fill me-1 text-warning"></i>
                        Identification
                    </label>

                    <select id="filter-id-status" class="form-select rounded-3">

                        <option value="">All IDs</option>
                        <option value="uploaded">Uploaded</option>
                        <option value="missing">Missing</option>
                        <option value="needs_review">Needs Review</option>

                    </select>

                </div>

                {{-- Date --}}
                <div class="col-md-6 col-lg-3">

                    <label class="form-label fw-semibold small">
                        <i class="bi bi-calendar3 me-1 text-warning"></i>
                        Date Submitted
                    </label>

                    <select id="filter-date" class="form-select rounded-3">

                        <option value="">All Dates</option>
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option>
                        <option value="custom">Custom Range</option>

                    </select>

                </div>

                {{-- From --}}
                <div class="col-md-6 d-none" id="custom-date-from-wrap">

                    <label class="form-label fw-semibold small">
                        From
                    </label>

                    <input id="filter-date-from" type="date" class="form-control rounded-3">

                </div>

                {{-- To --}}
                <div class="col-md-6 d-none" id="custom-date-to-wrap">

                    <label class="form-label fw-semibold small">
                        To
                    </label>

                    <input id="filter-date-to" type="date" class="form-control rounded-3">

                </div>

                {{-- Place --}}
                <div class="col-12">

                    <label class="form-label fw-semibold small">
                        <i class="bi bi-geo-alt-fill me-1 text-warning"></i>
                        Place of Examination
                    </label>

                    <input id="filter-place" type="text" class="form-control rounded-3"
                        placeholder="Search examination venue...">

                </div>

            </div>

        </div>

    </div>

    {{-- ================= Applicants Table ================= --}}
    <div class="card app-card border-0 shadow-lg rounded-4 overflow-hidden fade-in">

        {{-- Table Header --}}
        <div class="card-header border-0 bg-transparent py-3 px-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-table me-2 text-warning"></i>
                        Registered Applicants
                    </h5>

                    <small class="text-muted">
                        List of applicants registered for the
                        <strong>LIBRENG SAKAY ni Mayor Lemy</strong>.
                    </small>
                </div>

                <div id="table-toolbar"></div>

            </div>
        </div>

        <div class="table-responsive">

            <table id="applicants-table" class="table table-hover align-middle mb-0" data-toggle="table"
                data-url="{{ route('admin.applicants.data') }}" data-method="get" data-side-pagination="server"
                data-pagination="true" data-page-size="10" data-page-list="[10,25,50,100]" data-search="true"
                data-search-highlight="true" data-show-refresh="true" data-show-columns="true"
                data-show-columns-toggle-all="true" data-show-export="true" data-export-types="['csv','excel','pdf']"
                data-show-print="true" data-show-fullscreen="true" data-mobile-responsive="true"
                data-sticky-header="true" data-sticky-header-offset-y="72" data-loading-template="loadingTemplate"
                data-query-params="queryParams" data-response-handler="responseHandler" data-sort-name="id"
                data-sort-order="desc" data-id-field="id" data-unique-id="id" data-toolbar="#table-toolbar">

                <thead>

                    <tr>

                        <th data-field="id" data-width="70" data-sortable="true" data-align="center">
                            #
                        </th>

                        <th data-field="full_name" data-sortable="true" data-formatter="nameFormatter">
                            Applicant
                        </th>

                        <th data-field="applicant_type" data-width="180" data-sortable="true"
                            data-formatter="categoryFormatter">
                            Category
                        </th>

                        <th data-field="place_of_examination" data-sortable="true">
                            Examination Venue
                        </th>

                        <th data-field="contact_number" data-width="140" data-sortable="true">
                            Contact
                        </th>

                        <th data-field="email" data-sortable="true">
                            Email
                        </th>

                        <th data-field="id_status" data-width="130" data-sortable="true" data-align="center"
                            data-formatter="idStatusFormatter">
                            ID
                        </th>

                        <th data-field="verification_status" data-width="150" data-sortable="true" data-align="center"
                            data-formatter="statusFormatter">
                            Verification
                        </th>

                        <th data-field="created_at" data-width="170" data-sortable="true">
                            Registered
                        </th>

                        <th data-field="id" data-width="170" data-align="center" data-formatter="actionsFormatter">
                            Actions
                        </th>

                    </tr>

                </thead>

            </table>

        </div>
    </div>

    {{-- ── View Applicant Modal ────────────────────────────────────────────── --}}
    @include('applicant.management.partials.view-modal')

    {{-- ── Reject Modal ────────────────────────────────────────────────────── --}}
    @include('applicant.management.partials.reject-modal')

@endsection

@push('scripts')
    <script>
        // Route helpers for JS
        window.ApplicantRoutes = {
            statistics: @json(route('admin.applicants.statistics')),
            data: @json(route('admin.applicants.data')),
            show: @json(url('/admin/applicants')),
            verify: @json(url('/admin/applicants')),
            reject: @json(url('/admin/applicants')),
            destroy: @json(url('/admin/applicants')),
            downloadId: @json(url('/admin/applicants')),
        };
    </script>
    <script src="{{ asset('js/applicant-management.js') }}"></script>
@endpush
