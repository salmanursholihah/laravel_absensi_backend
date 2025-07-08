<h3>Rekap Keterlambatan</h3>
<p>Periode: {{ $start }} - {{ $end }}</p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Total Absen</th>
            <th>Total Terlambat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rekap as $data)
        <tr>
            <td>{{ $data->user->name ?? '-' }}</td>
            <td>{{ $data->total_absen }}</td>
            <td>{{ $data->total_terlambat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>