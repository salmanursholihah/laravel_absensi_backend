<!-- <!DOCTYPE html>
<html>

<head>
    <title>Laporan Catatan Users</title>
    <style>
    @page {}

    margin : 20mm 15mm;

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
    <h2>Laporan Catatan Users</h2>
    <table>
        <thead>

            <tr>
                <th>user ID</th>
                <th>name</th>
                <th>title</th>
                <th>deskripsi</th>
                <th>target</th>
                <th>kendala</th>
                <th>solusi</th>
                <th>create_at</th>
                <th>update_at</th>
            </tr>
            @foreach($catatans as $catatan)
            <tr>
                <td>{{ $catatan->user_id }}</td>
                <td>{{ $catatan->user->name ?? 'username tidak ditemukan' }}</td>
                <td>{{ $catatan->title }}</td>
                <td>{{ $catatan->description }}</td>
                <td>{{ $catatan->target }}</td>
                <td>{{ $catatan->kendala }}</td>
                <td>{{ $catatan->solusi }}</td>
                <td>{{ $catatan->created_at}}</td>
                <td>{{ $catatan->updated_at }}</td>
            </tr>
            @endforeach

            </tbody>
    </table>
</body>

</html> -->
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Catatan Users</title>
    <style>
    @page {
        size: A4 landscape;
        /* PAKSA LANDSCAPE */
        margin: 15mm;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 10pt;
        /* KECILKAN FONTSIZE */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        /* FIXED LAYOUT */
    }

    th,
    td {
        border: 1px solid #000;
        padding: 4px;
        /* KECILKAN PADDING */
        text-align: left;
        word-break: break-word;
        /* BUNGKUS KATA PANJANG */
    }

    th {
        background: #eee;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <h2>Laporan Catatan Users</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">User ID</th>
                <th style="width: 10%;">Name</th>
                <th style="width: 15%;">Title</th>
                <th style="width: 20%;">Deskripsi</th>
                <th style="width: 10%;">Target</th>
                <th style="width: 10%;">Kendala</th>
                <th style="width: 10%;">Solusi</th>
                <th style="width: 10%;">Tanggal Input</th>
            </tr>
        </thead>
        <tbody>
            @foreach($catatans as $catatan)
            <tr>
                <td>{{ $catatan->user_id }}</td>
                <td>{{ $catatan->user->name ?? 'N/A' }}</td>
                <td>{{ $catatan->title }}</td>
                <td>{{ $catatan->description }}</td>
                <td>{{ $catatan->target }}</td>
                <td>{{ $catatan->kendala }}</td>
                <td>{{ $catatan->solusi }}</td>
                <td>{{ $catatan->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>