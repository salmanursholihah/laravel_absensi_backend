@extends('layouts.app')

@section('title', 'Catatan')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Catatans</h1>
            <div class="section-header-button">
                <a href="{{ route('catatan.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Catatans</a></div>
                <div class="breadcrumb-item">All Catatans</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Catatans</h2>
            <p class="section-lead">
                You can manage all Catatans, such as editing, deleting and more.
            </p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                            <h4>All Posts</h4>
                            <div class="card-header-form">
                                <form method="GET" action="{{ route('pages.catatans.index') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search by title"
                                            name="name" value="{{ request('name') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($catatans as $catatan)
                                        <tr>
                                            <td>{{ $catatan->user->name ?? 'User tidak ditemukan' }}</td>
                                            <td>{{ $catatan->title }}</td>
                                            <td>{{ $catatan->description }}</td>
                                            <td>
                                                @if ($catatan->images && $catatan->images->count())
                                                @foreach($catatan->images as $image)
                                                <img src="{{ asset('storage/catatan_images/' . $image->image_path) }}"
                                                    width="80" style="margin: 2px; border-radius: 4px;">
                                                @endforeach
                                                @else
                                                <span>-</span>
                                                @endif
                                            </td>

                                            <td>{{ $catatan->created_at }}</td>
                                            <td>{{ $catatan->updated_at }}</td>
                                            <td>
                                                <a href="{{ route('catatan.edit', $catatan->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('catatan.destroy', $catatan->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Yakin hapus catatan ini?')"
                                                        class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data catatan</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="float-right m-3">
                                {{ $catatans->withQueryString()->links() }}
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
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush