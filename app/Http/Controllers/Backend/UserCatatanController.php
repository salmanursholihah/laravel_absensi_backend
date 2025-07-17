<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catatan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class UserCatatanController extends Controller
{

//     public function index()
//     {
//         if (auth()->user()->role === 'user') {
//             $catatans = Catatan::latest()->paginate(10);
//         } else {
//             $catatans = Catatan::where('user_id', auth()->id())
//                                ->latest()
//                                ->paginate(10);
//         }

//         return view('public.catatans.index', compact('catatans'));
//     }

//     public function create()
//     {
//         return view('public.catatans.create');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'title'       => 'required|string|max:255',
//             'description' => 'required|string',
//             'image'       => 'nullable|image|max:2048',
//         ]);

//         $imagePath = null;
//         if ($request->hasFile('image')) {
//             $imagePath = $request->file('image')->store('image_catatans', 'public');
//         }

//         Catatan::create([
//             'title'       => $request->title,
//             'description' => $request->description,
//             'image'       => $imagePath,
//             'user_id'     => auth()->id(),
//         ]);

//         return redirect()->route('catatan.index')->with('success', 'Catatan berhasil ditambahkan');
//     }

//     public function edit(Catatan $catatan)
//     {
    

//         return view('public.catatans.edit', compact('catatan'));
//     }

//     public function update(Request $request, Catatan $catatan)
//     {


//         $request->validate([
//             'title'       => 'required|string|max:255',
//             'description' => 'required|string',
//             'image'       => 'nullable|image|max:2048',
//         ]);

//         if ($request->hasFile('image')) {
//             if ($catatan->image && Storage::disk('public')->exists($catatan->image)) {
//                 Storage::disk('public')->delete($catatan->image);
//             }
//             $imagePath = $request->file('image')->store('image_catatans', 'public');
//         } else {
//             $imagePath = $catatan->image;
//         }

//         $catatan->update([
//             'title'       => $request->title,
//             'description' => $request->description,
//             'image'       => $imagePath,
//         ]);

//         return redirect()->route('catatan.index')->with('success', 'Catatan berhasil diperbarui');
//     }

//     public function destroy(Catatan $catatan)
//     {
     

//         if ($catatan->image && Storage::disk('public')->exists($catatan->image)) {
//             Storage::disk('public')->delete($catatan->image);
//         }

//         $catatan->delete();

//         return redirect()->route('catatan.index')->with('success', 'Catatan berhasil dihapus');
//     }
// }


// namespace App\Http\Controllers\Backend;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\Catatan;
// use App\MOdels\User;
// use App\Notifications\CatatanActionNotification;
// use Illuminate\Support\Facades\Storage;

// class UserCatatanController extends Controller
// {
    public function index()
    {
        if (auth()->user()->role === 'user') {
            $catatans = Catatan::where('user_id', auth()->id())
                               ->latest()
                               ->paginate(10);
        } else {
            $catatans = Catatan::latest()->paginate(10);
        }
                $today = now();
        $isEndOfMonth = $today->isSameDay($today->endOfMonth());

        // Ambil hanya catatan bulan ini
        $catatans = Auth::user()
            ->catatans()
            ->where('periode', $today->format('Y-m'))
            ->get();

        // Sudah ada evaluasi bulanan?
        $hasMonthly = Auth::user()
            ->catatans()
            ->where('periode', $today->format('Y-m'))
            ->whereNotNull('kendala')
            ->exists();

        $showMonthlyForm = $isEndOfMonth && !$hasMonthly;


        return view('public.catatans.index', compact('catatans'));
    }

    public function create()
    {
        return view('public.catatans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan catatan
        $catatan = Catatan::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        // Simpan gambar ke tabel relasi
       if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('catatan_images', 'public');

    $catatan->images()->create([
        'image_path' => $imagePath, 
    ]);
}

 // Kirim notifikasi ke admin misalnya
    $admins = User::where('role', 'admin')->get();
    foreach ($admins as $admin) {
        $admin->notify(new CatatanActionNotification($catatan, 'dibuat'));
    }
        return redirect()->route('public.catatans.index')->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function edit(Catatan $catatan)
    {
        if ($catatan->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('public.catatans.edit', compact('catatan'));
    }

    public function update(Request $request, Catatan $catatan)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data catatan
        $catatan->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Jika upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama kalau ada
            if ($catatan->image && Storage::disk('public')->exists($catatan->image->path)) {
                Storage::disk('public')->delete($catatan->image->path);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('catatan_images', 'public');

            if ($catatan->image) {
                $catatan->image->update(['path' => $imagePath]);
            } else {
                $catatan->image()->create(['path' => $imagePath]);
            }
        }

        return redirect()->route('public.catatans.index')->with('success', 'Catatan berhasil diperbarui.');
    }
    public function destroy(Catatan $catatan)
    {
        // Hapus file gambar kalau ada
        if ($catatan->image && Storage::disk('public')->exists($catatan->image->path)) {
            Storage::disk('public')->delete($catatan->image->path);
        }

        $catatan->delete();

        return redirect()->route('public.catatans.index')->with('success', 'Catatan berhasil dihapus.');
    }
}