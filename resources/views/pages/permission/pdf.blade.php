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


    <h2>Rekap permission bulanan</h2>

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