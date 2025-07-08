<form action="{{ route('work_schedules.store') }}" method="POST">
    @csrf

    <label for="user_id">Pilih User:</label>
    <select name="user_id" id="user_id">
        @foreach($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <h3>Input Jadwal 7 Hari:</h3>

    @for($i = 0; $i < 7; $i++) <div>
        <p><strong>Hari ke-{{ $i+1 }}</strong></p>
        <label>Tanggal:</label>
        <input type="date" name="dates[]" value="{{ \Carbon\Carbon::now()->addDays($i)->format('Y-m-d') }}">
        <label>Jam Masuk:</label>
        <input type="time" name="start_times[]" required>
        <label>Jam Pulang:</label>
        <input type="time" name="end_times[]" required>
        </div>
        <hr>
        @endfor

        <button type="submit">Simpan Jadwal Minggu Ini</button>
</form>