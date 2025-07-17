@extends('layouts.app')

@section('title', 'Input Catatan')

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
            <h1>Tambah Catatan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Catatan</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Form Catatan</h2>

            <div class="card">
                <form id="multiStepForm" action="{{ route('catatan.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Input Catatan</h4>
                    </div>

                    <!-- Step 1 -->
                    <div class="card-body step-content" id="step-1">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title') }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                name="description">{{ old('description') }}</textarea>
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
                        </div>

                        <div class="card-footer text-right">
                            @if ($showMonthlyForm)
                            @php
                            $today = \Carbon\Carbon::now();
                            $isEndOfMonth = $today->day >= 28 && $today->day <= $today->daysInMonth;
                                @endphp

                                @if($isEndOfMonth)
                                <a href="{{ route('evaluasi.bulanan') }}" class="btn btn-primary">Lanjut Evaluasi
                                    Bulanan</a>
                                @endif

                                @endif
                                <button type="submit" id="submitDailyOnly" class="btn btn-success">Simpan
                                    Harian</button>
                        </div>

                    </div>

                    <!-- Step 2 -->
                    <div class="card-body step-content d-none" id="step-2">
                        <div class="form-group">
                            <label>Target</label>
                            <textarea class="form-control @error('target') is-invalid @enderror"
                                name="target">{{ old('target') }}</textarea>
                            @error('target')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Permasalahan</label>
                            <textarea class="form-control @error('kendala') is-invalid @enderror"
                                name="kendala">{{ old('kendala') }}</textarea>
                            @error('kendala')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Uraian Penyelesaian</label>
                            <textarea class="form-control @error('solusi') is-invalid @enderror"
                                name="solusi">{{ old('solusi') }}</textarea>
                            @error('solusi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Simpan Semua</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('nextToMonthly').addEventListener('click', function() {
    document.getElementById('step-1').classList.add('d-none');
    document.getElementById('step-2').classList.remove('d-none');
});
</script>
@endpush