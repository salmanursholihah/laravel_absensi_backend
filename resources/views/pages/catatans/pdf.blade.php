<h3>Daftar Catatan</h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($catatans as $catatan)
        <tr>
            <td>{{ $catatan->title }}</td>
            <td>{{ $catatan->description }}</td>
            <td>{{ $catatan->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>