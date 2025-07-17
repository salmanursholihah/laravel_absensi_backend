@extends('layouts.app_admin')

@section('title', 'dashboard_admin')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/style/style_table_admin.css') }}">
@endpush

<div class="content">
    <h2>Data catatan masuk</h2>

    <table>
        @auth
        @if(auth()->user()->role === 'admin')

        <div>
            <a href="{{ route('catatan.export.excel') }}" class="btn btn-success">Export Excel</a>
            <a href="{{ route('catatan.export.pdf') }}" class="btn btn-primary">Export PDF</a>

            <br><br>

            <!-- Export data per bulan -->
            <form method="POST" action="{{ route('export.perbulan') }}">
                @csrf
                <input type="number" name="month" value="{{ date('m') }}">
                <input type="number" name="year" value="{{ date('Y') }}">
                <button type="submit" class="btn btn-warning">Download PDF</button>
            </form>

            <!-- Form export per user -->
            <form action="{{ route('export.peruser') }}" method="POST">
                @csrf
                <label for="user_id">Pilih User:</label>
                <select name="user_id" id="user_id">
                    @if(isset($users) && count($users))
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                    @else
                    <option value="">Tidak ada user tersedia</option>
                    @endif
                </select>
                <button type="submit">Export PDF</button>
            </form>
        </div>
        <br>

        @endif
        @endauth

        <!-- Struktur table diperbaiki -->
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Title</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>target</th>
                <th>kendala</th>
                <th>solusi</th>
                <th>tanggal input</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($catatans as $catatan)
            <tr>
                <td>{{ $catatan->user_id }}</td>
                <td>{{ $catatan->user->name ?? 'username tidak ditemukan' }}</td>
                <td>{{ $catatan->title }}</td>
                <td>{{ $catatan->description }}</td>
                <td>
                    @if($catatan->images && $catatan->images->count())
                    @foreach($catatan->images as $image)
                    <img src="{{ asset($image->image_path) }}" width="80" style="margin: 2px; border-radius: 4px;">
                    @endforeach
                    @else
                    Tidak ada gambar
                    @endif
                </td>
                <td>{{ $catatan->Target }}</td>
                <td>{{ $catatan->kendala }}</td>
                <td>{{ $catatan->solusi }}</td>
                <td>{{ $catatan->created_at }}</td>
                <td>
                    <a href="{{ route('admin.catatans.edit', $catatan->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.catatans.destroy', $catatan->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin hapus user ini?')" class="btn btn-primary">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection