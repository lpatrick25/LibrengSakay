@extends('errors.minimal')

@section('title', 'Page Not Found')

@section('icon')
    <i class="bi bi-search text-primary"></i>
@endsection

@section('code', '404')

@section('heading', 'Page Not Found')

@section('message')
    The page you are looking for doesn't exist or may have been moved.
@endsection
