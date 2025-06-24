@extends('layouts.app')

@section('title', 'Edit Company')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Company</h1>
        </div>
        <div class="section-body">
            <form action="{{ route('companies.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}"
                        required>
                </div>
                <div class="form-group">
                    <label>Email Perusahaan</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $company->email) }}"
                        required>
                </div>
                <div class="form-group">
                    <label>Alamat Perusahaan</label>
                    <textarea name="address" class="form-control"
                        required>{{ old('address', $company->address) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Latitude</label>
                    <input type="number" step="any" name="latitude" class="form-control"
                        value="{{ old('latitude', $company->latitude) }}" required>
                </div>
                <div class="form-group">
                    <label>Longitude</label>
                    <input type="number" step="any" name="longitude" class="form-control"
                        value="{{ old('longitude', $company->longitude) }}" required>
                </div>
                <div class="form-group">
                    <label>Radius KM</label>
                    <input type="number" step="any" name="radius_km" class="form-control"
                        value="{{ old('radius_km', $company->radius_km) }}" required>
                </div>
                <div class="form-group">
                    <label>Waktu Masuk</label>
                    <input type="time" name="time_in" class="form-control"
                        value="{{ old('time_in', $company->time_in) }}" required>
                </div>
                <div class="form-group">
                    <label>Waktu Pulang</label>
                    <input type="time" name="time_out" class="form-control"
                        value="{{ old('time_out', $company->time_out) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('companies.show') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </section>
</div>
@endsection