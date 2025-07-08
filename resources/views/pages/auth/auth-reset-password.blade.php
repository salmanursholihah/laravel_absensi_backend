@extends('layouts.auth')

@section('title', 'Login')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')
<div class="card card-primary">
    <div class="card-header">
        <h4>Reset password</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ request()->route('token') }}">
            <input type="hidden" name="email" value="{{ request()->email }}">

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" required class="form-control">
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>

    </div>
    @endsection
    @push('scripts')

    @endpush