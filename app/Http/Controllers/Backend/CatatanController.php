<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catatan;

class CatatanController extends Controller
{
    public function index()
    {
        $catatans = Catatan::latest()->paginate(10); // Urut berdasarkan created_at
        return view('pages.catatans.index', compact('catatans'));
    }

    public function create()
    {
        return view('pages.catatans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('image_catatans', 'public');
        }

        Catatan::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
            'user_id'     => auth()->id(),
        ]);

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil ditambahkan');
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
            'image'       => 'nullable|image|max:2048',
        ]);

        $imagePath = $catatan->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('image_catatans', 'public');
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
        $catatan->delete();
        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil dihapus');
    }
}