@extends('layouts.app')

@section('title', 'Email Template Management')
@section('container-class', 'container-fluid px-3 px-lg-4')

@section('content')

    {{-- ── Page Header ───────────────────────────────────────────────────── --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4 fade-in">
        <div>
            <h1 class="h3 fw-bold mb-1">
                <i class="bi bi-envelope-paper-fill text-primary me-2"></i>
                Email Template Management
            </h1>
            <p class="text-muted mb-0 small">
                Configure email templates used for applicant notifications, approvals, and rejections.
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <button type="button" id="btn-refresh-templates" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-clockwise me-1"></i>
                Refresh
            </button>
        </div>
    </div>

    {{-- ── Skeleton Loading ─────────────────────────────────────────────── --}}
    <div id="templates-skeleton" class="row g-4">
        @for ($i = 0; $i < 2; $i++)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <div class="card-body p-4">

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="skeleton skeleton-circle" style="width:48px;height:48px;"></div>

                            <div class="flex-grow-1">
                                <div class="skeleton skeleton-text mb-2" style="width:55%;height:20px;"></div>

                                <div class="skeleton skeleton-text" style="width:75%;height:12px;"></div>
                            </div>
                        </div>

                        <div class="skeleton skeleton-text mb-2" style="width:100%;height:14px;"></div>

                        <div class="skeleton skeleton-text mb-2" style="width:90%;height:14px;"></div>

                        <div class="skeleton skeleton-text mb-4" style="width:70%;height:14px;"></div>

                        <div class="d-flex gap-2">
                            <div class="skeleton rounded-pill" style="width:90px;height:36px;"></div>

                            <div class="skeleton rounded-pill" style="width:90px;height:36px;"></div>
                        </div>

                    </div>
                </div>
            </div>
        @endfor
    </div>

    {{-- ── Template Cards (AJAX) ─────────────────────────────────────────── --}}
    <div id="templates-cards" class="row g-4 d-none"></div>

    {{-- ── Modals ────────────────────────────────────────────────────────── --}}
    @include('email-templates.partials.edit-modal')
    @include('email-templates.partials.preview-modal')
    @include('email-templates.partials.test-modal')

@endsection

@push('scripts')
    {{-- CKEditor 5 --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <script>
        window.EmailTemplateRoutes = {
            data: @json(route('admin.email-templates.data')),
            show: @json(url('/admin/email-templates')),
            update: @json(url('/admin/email-templates')),
            toggle: @json(url('/admin/email-templates')),
            preview: @json(url('/admin/email-templates')),
            test: @json(url('/admin/email-templates')),
        };
    </script>

    <script src="{{ asset('js/email-templates.js') }}"></script>
@endpush
