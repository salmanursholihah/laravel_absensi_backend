@extends('layouts.app')

@section('title', 'Companies')

@push('style')
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Companies</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Companies</a></div>
                <div class="breadcrumb-item">All Companies</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Companies</h2>
            <div class="section-header-button">
                <a href="{{ route('companies.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <p class="section-lead">
                You can manage all companies, such as editing, deleting and more.
            </p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Companies</h4>
                            <div class="ml-auto">
                                <form method="GET" action="{{ route('companies.index') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search by name"
                                            name="name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Radius (km)</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($companies as $company)
                                        <tr>
                                            <td>{{ $company->id }}</td>
                                            <td>{{ $company->name }}</td>
                                            <td>{{ $company->email }}</td>
                                            <td>{{ $company->address }}</td>
                                            <td>{{ $company->latitude }}</td>
                                            <td>{{ $company->longitude }}</td>
                                            <td>{{ $company->radius_km }}</td>
                                            <td>{{ $company->time_in }}</td>
                                            <td>{{ $company->time_out }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('companies.edit', $company->id) }}"
                                                        class="btn btn-sm btn-info btn-icon mr-1">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('companies.destroy', $company->id) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger btn-icon">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No companies found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="float-right mt-3">
                                {{ $companies->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush