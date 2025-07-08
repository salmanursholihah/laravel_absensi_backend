<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catatan;
use Illuminate\Support\Facades\Storage;

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
        // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only(['title', 'description']);

    // Upload gambar jika ada
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('catatan_images', 'public');
        $data['image'] = $imagePath;
    }

    // Tambahkan user_id jika perlu
    $data['user_id'] = auth()->id();

    // Simpan ke database
    \App\Models\Catatan::create($data);

    return redirect()->route('catatan.index')->with('success', 'Catatan berhasil ditambahkan.');
}

    public function edit(Catatan $catatan)
    {
    

        return view('pages.catatans.edit', compact('catatan'));
    }

    public function update(Request $request, Catatan $catatan)
    {


        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            // 'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($catatan->image && Storage::disk('public')->exists($catatan->image)) {
                Storage::disk('public')->delete($catatan->image);
            }
            $imagePath = $request->file('image')->store('image_catatans', 'public');
        } else {
            $imagePath = $catatan->image;
        }

        $catatan->update([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil diperbarui');
    }

    public function destroy(Catatan $catatan)
    {
     

        if ($catatan->image && Storage::disk('public')->exists($catatan->image)) {
            Storage::disk('public')->delete($catatan->image);
        }

        $catatan->delete();

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil dihapus');
    }
}