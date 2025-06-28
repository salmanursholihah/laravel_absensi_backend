<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catatan;
use Illuminate\Support\Facades\Storage;


class UserCatatanController extends Controller
{

    public function index()
    {
        if (auth()->user()->role === 'user') {
            $catatans = Catatan::latest()->paginate(10);
        } else {
            $catatans = Catatan::where('user_id', auth()->id())
                               ->latest()
                               ->paginate(10);
        }

        return view('public.catatans.index', compact('catatans'));
    }

    public function create()
    {
        return view('public.catatans.create');
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
    

        return view('public.catatans.edit', compact('catatan'));
    }

    public function update(Request $request, Catatan $catatan)
    {


        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048',
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