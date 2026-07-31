@extends('errors.minimal')

@section('title', 'Too Many Requests')

@section('icon')
    <i class="bi bi-speedometer2 text-warning"></i>
@endsection

@section('code', '429')

@section('heading', 'Too Many Requests')

@section('message')
    You've made too many requests in a short period. Please wait a few moments before trying again.
@endsection
