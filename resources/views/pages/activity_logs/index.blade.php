<!-- @extends('layouts.app')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Log Aktivitas</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Model</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->created_at }}</td>
                                <td>{{ $log->user->name ?? 'User tidak ditemukan' }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->model_type }} (ID: {{ $log->model_id }})</td>
                                <td>{{ $log->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection -->


<table>
    <thead>
        <tr>
            <th>User</th>
            <th>Action</th>
            <th>Description</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        <tr>
            <td>{{ $log->user->name ?? 'System' }}</td>
            <td>{{ $log->action }}</td>
            <td>{{ $log->description }}</td>
            <td>{{ $log->created_at->diffForHumans() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>