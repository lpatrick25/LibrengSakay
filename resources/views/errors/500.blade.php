@extends('errors.minimal')

@section('title', 'Server Error')

@section('icon')
    <i class="bi bi-exclamation-octagon-fill text-danger"></i>
@endsection

@section('code', '500')

@section('heading', 'Internal Server Error')

@section('message')
    Something went wrong on our side. Please try again later.
@endsection
