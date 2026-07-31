@extends('errors.minimal')

@section('title', 'Forbidden')

@section('icon')
    <i class="bi bi-shield-lock-fill text-danger"></i>
@endsection

@section('code', '403')

@section('heading', 'Access Denied')

@section('message')
    You don't have permission to access this page.
@endsection
