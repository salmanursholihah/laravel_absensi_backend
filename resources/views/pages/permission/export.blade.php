<!DOCTYPE html>
<html>

<head>
    <title>Laporan permission Users {{ $month }}/{{ $year }}</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
    </style>
</head>

<body>
    <h2>Laporan permission Users {{ $month }}/ {{ $year }}</h2>
    <table>
        <thead>
            <th>id_user</th>
            <th>date_permission</th>
            <th>reason</th>
            <th>Is approved</th>

        </thead>
        <tbody>
            @foreach ($permissions as $item)
            <tr>
                <td>{{ $item->user_id}}</td>
                <td>{{ $item->date_permission }}</td>
                <td>{{ $item->reason }}</td>
                <td>{{ $item->is_approved }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>