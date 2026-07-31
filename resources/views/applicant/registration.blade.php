@extends('layouts.app')

@section('title', 'Applicant Registration')

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
