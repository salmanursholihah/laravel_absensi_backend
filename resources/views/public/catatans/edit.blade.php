@extends('layouts.app')

@section('title', 'Edit Catatan')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('backend/asset/library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet"
    href="{{ asset('backend/asset/library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/selectric/public/selectric.css') }}">
<link rel="stylesheet"
    href="{{ asset('backend/asset/library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Catatan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Catatan</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Edit Catatan</h2>

            <div class="card">
                <form action="{{ route('catatan.update', $catatan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Form Edit Catatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title', $catatan->title) }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                name="description">{{ old('description', $catatan->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($catatan->image)
                            <small class="d-block mt-2">Gambar sekarang:</small>
                            <img src="{{ asset('storage/' . $catatan->image) }}" alt="gambar"
                                style="max-height: 150px;">
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush