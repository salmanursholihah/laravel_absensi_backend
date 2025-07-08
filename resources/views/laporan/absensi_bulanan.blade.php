<!DOCTYPE html>
<html>

<head>
    <title>Rekap Absensi PDF</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #333;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    h2 {
        text-align: center;
    }
    </style>
</head>

<body>
    <h2>Rekap Absensi bulanan</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>id_user</th>
                <th>time_in</th>
                <th>time_out</th>
                <th>status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $item)
            <tr>
                <td>{{ $item->date }}</td>
                <td>{{ $item->user_id }}</td>
                <td>{{ $item->time_in }}</td>
                <td>{{ $item->time_out }}</td>
                <td>{{ $item->status }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>