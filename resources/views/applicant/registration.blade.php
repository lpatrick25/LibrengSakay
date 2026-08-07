@extends('layouts.app')

@section('title', 'Applicant Registration')

@push('styles')
    <style>
        .position-relative {
            position: relative;
        }

        .registration-overlay {
            position: absolute;
            inset: 0;
            z-index: 100;
            display: flex;
            justify-content: center;
            align-items: center;

            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);

            background: rgba(255, 255, 255, .75);
            border-radius: 1rem;
        }

        .registration-overlay-card {
            width: min(550px, 90%);
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 .75rem 2rem rgba(0, 0, 0, .15);
        }

        .registration-overlay-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 1.5rem;

            border-radius: 50%;
            background: #fff3cd;
            color: #b8860b;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 2.5rem;
        }

        .registration-closed #category-cards {
            opacity: .45;
            pointer-events: none;
            user-select: none;
        }

        .registration-overlay-icon.success {
            background: #e9ecef;
            color: #6c757d;
        }

        .registration-overlay-icon.warning {
            background: #fff3cd;
            color: #b8860b;
        }
    </style>
@endpush

@section('content')
    <div id="registration-app" class="mx-auto" style="max-width: 960px;">

        {{-- Skeleton loader (shown initially) --}}
        <div id="page-skeleton" class="fade-in">
            @include('components.skeleton')
        </div>

        {{-- Step 1: Category Selection --}}
        <div id="step-category" class="d-none">
            @include('applicant.partials.category-selection')
        </div>

        {{-- Step 2: Registration Form --}}
        <div id="step-form" class="d-none">
            @include('applicant.partials.registration-form')
        </div>

    </div>
@endsection
