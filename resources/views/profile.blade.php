@extends('layouts.app')

@section('title', 'Companies')

@push('style')
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">profile</a></div>
            </div>
        </div>

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Nama -->
    <div class="mb-3">
        <label>Nama</label>
        <input name="name" class="form-control" value="{{ old('name', $user->name) }}">
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <!-- Avatar -->
    <div class="mb-3">
        <label>Avatar</label>
        <input type="file" name="avatar" class="form-control">
        @error('avatar') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label>Email</label>
        <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}">
        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label>Password Baru (opsional)</label>
        <input name="password" type="password" class="form-control">
        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <!-- Konfirmasi Password -->
    <div class="mb-3">
        <label>Konfirmasi Password</label>
        <input name="password_confirmation" type="password" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
</div>

@if (auth()->user()->avatar)
<img src="{{ asset('storage/avatars/' . auth()->user()->avatar) }}" width="100">
@else
<img src="{{ asset('storage/avatars/default.png') }}" width="100">
@endif
@endsection