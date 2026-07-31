@extends('errors.minimal')

@section('title', 'Page Expired')

@section('icon')
    <i class="bi bi-hourglass-split text-warning"></i>
@endsection

@section('code', '419')

@section('heading', 'Page Expired')

@section('message')
    Your session has expired. Please refresh the page and try again.
@endsection
