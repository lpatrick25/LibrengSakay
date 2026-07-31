@extends('errors.minimal')

@section('title', 'Unauthorized')

@section('icon')
    <i class="bi bi-lock-fill text-warning"></i>
@endsection

@section('code', '401')

@section('heading', 'Unauthorized')

@section('message')
    You must sign in before accessing this page.
@endsection
