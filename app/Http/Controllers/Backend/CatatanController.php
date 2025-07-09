<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catatan;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLogs;
use App\Models\User;
use App\Notifications\CatatanActionNotification;

class CatatanController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $catatans = Catatan::latest()->paginate(10);
        } else {
            $catatans = Catatan::where('user_id', auth()->id())
                               ->latest()
                               ->paginate(10);
        }

        return view('pages.catatans.index', compact('catatans'));
    }

    public function create()
    {
        return view('pages.catatans.create');
    }

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $data = $request->only(['title', 'description']);
    $data['user_id'] = auth()->id();

    $catatan = \App\Models\Catatan::create($data);

    ActivityLogs::create([
        'user_id' => auth()->id(),
        'action' => 'create',
        'model_type' => Catatan::class,
        'model_id' => $catatan->id,
        'description' => "Membuat catatan #{$catatan->id} dengan judul '{$catatan->title}'",
    ]);
      // Kirim notifikasi ke admin misalnya
    $admins = User::where('role', 'admin')->get();
    foreach ($admins as $admin) {
        $admin->notify(new CatatanActionNotification($catatan, 'dibuat'));
    }

    return redirect()->route('catatan.index')->with('success', 'Catatan berhasil ditambahkan.');
}

    public function edit(Catatan $catatan)
    {
    

        return view('pages.catatans.edit', compact('catatan'));
    }

public function update(Request $request, Catatan $catatan)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $catatan->update([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    ActivityLogs::create([
        'user_id' => auth()->id(),
        'action' => 'update',
        'model_type' => Catatan::class,
        'model_id' => $catatan->id,
        'description' => "Memperbarui catatan #{$catatan->id} menjadi '{$catatan->title}'",
    ]);

    $admins = User::where('role', 'admin')->get();
    foreach ($admins as $admin) {
        $admin->notify(new CatatanActionNotification($catatan, 'diupdate'));
    }
    return redirect()->route('catatan.index')->with('success', 'Catatan berhasil diperbarui');
}


public function destroy(Catatan $catatan)
{
    $catatanId = $catatan->id;
    $catatanTitle = $catatan->title;

    $catatan->delete();

    ActivityLogs::create([
        'user_id' => auth()->id(),
        'action' => 'delete',
        'model_type' => Catatan::class,
        'model_id' => $catatanId,
        'description' => "Menghapus catatan #{$catatanId} berjudul '{$catatanTitle}'",
    ]);
        $admins = User::where('role', 'admin')->get();
    foreach ($admins as $admin) {
        $admin->notify(new CatatanActionNotification($catatan, 'dihapus'));
    }

    return redirect()->route('catatan.index')->with('success', 'Catatan berhasil dihapus');
}
}