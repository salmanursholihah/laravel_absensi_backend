<table>
    <thead>
        <tr>
            <th>User</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($work_schedules as $ws)
        <tr>
            <td>{{ $ws->user->name }}</td>
            <td>{{ $ws->date }}</td>
            <td>{{ $ws->start_time }}</td>
            <td>{{ $ws->end_time }}</td>
        </tr>
        @endforeach
    </tbody>
</table>