@extends('layouts.app')

@section('title', 'User Management')
@section('container-class', 'container-fluid px-3 px-lg-4')

@section('content')

    {{-- ═══════════════════════════════════════════════════════════════
    User Management Header
═══════════════════════════════════════════════════════════════ --}}
    <div class="card border-0 shadow-sm rounded-4 honey-header mb-4 fade-in overflow-hidden">
        <div class="card-body p-4">

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">

                {{-- Title --}}
                <div class="d-flex align-items-center gap-3">

                    <div class="hex-icon bg-warning-subtle text-warning">
                        <i class="bi bi-person-gear-fill"></i>
                    </div>

                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                ADMINISTRATION
                            </span>
                        </div>

                        <h1 class="h3 fw-bold mb-1">
                            User Management
                        </h1>

                        <p class="text-muted mb-0">
                            Create user accounts, manage access permissions, and maintain
                            administrative records for the Applicant Registration System.
                        </p>
                    </div>

                </div>

                {{-- Actions --}}
                <div class="d-flex flex-wrap justify-content-lg-end gap-2">

                    <button type="button" id="btn-add-user" class="btn btn-warning rounded-pill px-4">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        Add User
                    </button>

                    <button type="button" id="btn-refresh-all" class="btn btn-outline-warning rounded-pill px-4">
                        <i class="bi bi-arrow-clockwise me-2"></i>
                        Refresh
                    </button>

                    <div class="btn-group">

                        <button type="button"
                            class="btn btn-outline-warning rounded-pill rounded-end-0 px-4 dropdown-toggle"
                            data-bs-toggle="dropdown">

                            <i class="bi bi-download me-2"></i>
                            Export
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4">

                            <li>
                                <a class="dropdown-item py-2" href="#" id="btn-export-csv">
                                    <i class="bi bi-filetype-csv text-success me-2"></i>
                                    Export CSV
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item py-2" href="#" id="btn-export-excel">
                                    <i class="bi bi-file-earmark-excel text-success me-2"></i>
                                    Export Excel
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item py-2" href="#" id="btn-export-pdf">
                                    <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                    Export PDF
                                </a>
                            </li>

                        </ul>

                    </div>

                    <button type="button" id="btn-print-table" class="btn btn-outline-secondary rounded-pill px-4">

                        <i class="bi bi-printer me-2"></i>
                        Print
                    </button>

                </div>

            </div>

        </div>
    </div>

    {{-- Statistics Skeleton --}}
    <div id="user-stats-skeleton" class="row g-3 mb-4">
        @for ($i = 0; $i < 4; $i++)
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-3">
                        <div class="skeleton skeleton-circle mb-2" style="width:36px;height:36px;"></div>
                        <div class="skeleton skeleton-text mb-1" style="width:50%;height:24px;"></div>
                        <div class="skeleton skeleton-text" style="width:70%;height:12px;"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    {{-- Statistics Cards --}}
    <div id="user-stats-cards" class="row g-3 mb-4 d-none">
        @include('users.partials.stats-cards')
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
    Filters
═══════════════════════════════════════════════════════════════ --}}
    <div class="card border-0 shadow-sm rounded-4 honey-card mb-4 fade-in">

        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <div class="d-flex align-items-center gap-2">
                    <div class="hex-icon-sm bg-warning-subtle text-warning">
                        <i class="bi bi-funnel-fill"></i>
                    </div>

                    <div>
                        <h2 class="h6 fw-bold mb-0">
                            Filter Users
                        </h2>
                        <small class="text-muted">
                            Narrow down user records
                        </small>
                    </div>
                </div>

                <button type="button" id="btn-reset-filters" class="btn btn-link btn-sm text-decoration-none fw-semibold">

                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    Reset Filters

                </button>

            </div>
        </div>

        <div class="card-body px-4 pb-4">

            <div class="row g-3">

                {{-- Search --}}
                <div class="col-12 col-lg-4">

                    <label class="form-label small text-muted fw-semibold">
                        Search User
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text" id="filter-search" class="form-control" placeholder="Name or email...">

                    </div>

                </div>

                {{-- Email Status --}}
                <div class="col-6 col-lg-2">

                    <label class="form-label small text-muted fw-semibold">
                        Email Status
                    </label>

                    <select id="filter-email-status" class="form-select">

                        <option value="">All Users</option>
                        <option value="verified">Verified</option>
                        <option value="unverified">Unverified</option>

                    </select>

                </div>

                {{-- Created --}}
                <div class="col-6 col-lg-2">

                    <label class="form-label small text-muted fw-semibold">
                        Created
                    </label>

                    <select id="filter-date" class="form-select">

                        <option value="">Any Time</option>
                        <option value="today">Today</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option>
                        <option value="custom">Custom Range</option>

                    </select>

                </div>

                {{-- From --}}
                <div class="col-6 col-lg-2 d-none" id="custom-date-from-wrap">

                    <label class="form-label small text-muted fw-semibold">
                        From
                    </label>

                    <input type="date" id="filter-date-from" class="form-control">

                </div>

                {{-- To --}}
                <div class="col-6 col-lg-2 d-none" id="custom-date-to-wrap">

                    <label class="form-label small text-muted fw-semibold">
                        To
                    </label>

                    <input type="date" id="filter-date-to" class="form-control">

                </div>

            </div>

        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════
    User Directory
═══════════════════════════════════════════════════════════════ --}}
    <div class="card border-0 shadow-sm rounded-4 honey-card fade-in overflow-hidden">

        {{-- Card Header --}}
        <div class="card-header bg-transparent border-0 px-4 pt-4 pb-3">

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="hex-icon-sm bg-warning-subtle text-warning">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div>
                        <h2 class="h5 fw-bold mb-1">
                            User Directory
                        </h2>

                        <p class="text-muted small mb-0">
                            Browse, search, and manage registered system users.
                        </p>
                    </div>

                </div>

                <span class="badge bg-light text-secondary rounded-pill px-3 py-2">
                    <i class="bi bi-database me-1"></i>
                    System Records
                </span>

            </div>

        </div>

        {{-- Table --}}
        <div class="table-responsive">

            <table id="users-table" class="table table-hover align-middle mb-0" data-toggle="table"
                data-url="{{ route('admin.users.data') }}" data-side-pagination="server" data-pagination="true"
                data-page-size="10" data-page-list="[10,25,50,100]" data-search="true" data-search-highlight="true"
                data-show-refresh="true" data-show-columns="true" data-show-columns-toggle-all="true"
                data-show-export="true" data-show-print="true" data-show-fullscreen="true"
                data-export-types="['csv','excel','pdf']" data-sticky-header="true" data-sticky-header-offset-y="72"
                data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc" data-id-field="id"
                data-unique-id="id" data-loading-template="userLoadingTemplate" data-query-params="userQueryParams"
                data-response-handler="userResponseHandler" data-classes="table table-hover align-middle"
                data-thead-classes="table-light">

                <thead>

                    <tr>

                        <th data-field="id" data-width="80" data-sortable="true">

                            #
                        </th>

                        <th data-field="name" data-sortable="true" data-formatter="userNameFormatter">

                            User
                        </th>

                        <th data-field="email" data-sortable="true">

                            Email Address
                        </th>

                        <th data-field="email_verified" data-width="150" data-sortable="true" data-align="center"
                            data-formatter="emailStatusFormatter">

                            Status
                        </th>

                        <th data-field="created_at" data-width="170" data-sortable="true">

                            Created
                        </th>

                        <th data-field="updated_at" data-width="170" data-sortable="true">

                            Updated
                        </th>

                        <th data-field="id" data-width="150" data-align="center" data-formatter="userActionsFormatter">

                            Actions
                        </th>

                    </tr>

                </thead>

            </table>

        </div>

    </div>

    {{-- Modals --}}
    @include('users.partials.create-modal')
    @include('users.partials.edit-modal')
    @include('users.partials.view-modal')

@endsection

@push('scripts')
    <script>
        window.UserRoutes = {
            statistics: @json(route('admin.users.statistics')),
            data: @json(route('admin.users.data')),
            store: @json(route('admin.users.store')),
            show: @json(url('/admin/users')),
            update: @json(url('/admin/users')),
            destroy: @json(url('/admin/users')),
        };
        window.passwordMinLength = {{ (int) config('auth.password_min_length', env('PASSWORD_MIN_LENGTH', 8)) }};
    </script>
    <script src="{{ asset('js/user-management.js') }}"></script>
@endpush
