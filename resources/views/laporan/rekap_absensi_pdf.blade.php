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
    <h2>Rekap Absensi Per Hari</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Hari</th>
                <th>Total Absensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapPerHari as $item)
            <tr>
                <td>{{ $item->date }}</td>
                <td>{{ $item->total_absen }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>