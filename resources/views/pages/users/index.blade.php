@extends('layouts.app')

@section('title', 'Users')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('backend/asset/library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Users</h1>
            <div class="section-header-button">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Users</a></div>
                <div class="breadcrumb-item">All Users</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Users</h2>
            <p class="section-lead">
                You can manage all Users, such as editing, deleting and more.
            </p>


            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Posts</h4>
                        </div>
                        <div class="card-body">

                            <div class="float-right">
                                <!-- <form method="GET" action="{{ route('users.index') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form> -->

                                <form method="GET" action="{{ route('users.index') }}"
                                    class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                                    <input type="text" name="name" placeholder="Cari Nama" value="{{ request('name') }}"
                                        class="form-input w-full">

                                    <select name="companie_id" class="form-select w-full">
                                        <option value="">-- Semua Perusahaan --</option>
                                        @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ request('companie_id') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    <!-- <input type="date" name="created_at" value="{{ request('created_at') }}"
                                        class="form-input w-full">
                                    <input type="date" name="updated_at" value="{{ request('updated_at') }}"
                                        class="form-input w-full"> -->

                                    <button type="submit" class="btn btn-primary">
                                        Filter
                                    </button>
                                </form>

                            </div>

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <tr>

                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Position</th>
                                        <th>Created At</th>
                                        <th>Company_ID</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($users as $user)
                                    <tr>

                                        <td>{{ $user->name }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ $user->phone }}
                                        </td>
                                        <td>
                                            {{ $user->position }}
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->companies_id }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href='{{ route('users.edit', $user->id) }}'
                                                    class="btn btn-sm btn-info btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                    Edit
                                                </a>

                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="ml-2">
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                        <i class="fas fa-times"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach


                                </table>
                            </div>
                            <div class="float-right">
                                {{ $users->withQueryString()->links() }}
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
<!-- JS Libraies -->
<script src="{{ asset('backend/asset/library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('backend/asset/js/page/features-posts.js') }}"></script>
@endpush