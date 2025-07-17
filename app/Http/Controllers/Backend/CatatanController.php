<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catatan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
class CatatanController extends Controller
{
 public function index()
{
    if (auth()->user()->role === 'admin') {
        $catatans = Catatan::latest()->paginate(10);
        $users = User::all(); // ⬅️ Tambahkan ini!
    } else {
        $catatans = Catatan::where('user_id', auth()->id())
                           ->latest()
                           ->paginate(10);
        $users = collect(); // Supaya variable selalu ada
    }

    return view('pages.catatans.index', compact('catatans', 'users'));
}


    public function create()
{
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

    // ❗❗ KIRIMKAN ke VIEW di sini:
    return view('pages.catatans.create', [
        'showMonthlyForm' => $showMonthlyForm,
        'catatans' => $catatans,
    ]);
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         'kendala' => 'nullable|string',
            'solusi' => 'nullable|string',
            'target' => 'nullable|string',
    ]);

    $data = $request->only(['title', 'description','kendala', 'solusi', 'target']);

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
             'kendala' => 'nullable|string',
            'solusi' => 'nullable|string',
            'target' => 'nullable|string',
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
               'kendala' => $request->kendala,
            'solusi' => $request->solusi,
            'target' => $request->target,
            'periode' => now()->format('Y-m'),
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
    public function exportPDF()
    {
        $catatans = Catatan::all();
        $pdf = Pdf::loadView('pages.catatans.pdf', compact('catatans'));
        $pdf->setPaper('A4','landscape');

        return $pdf->download('laporan_catatan.pdf');
    }
    public function exportPerBulan( request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $catatans = Catatan::whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->get();

   $pdf = Pdf::loadView('pages.catatans.export', compact('catatans', 'month', 'year'));
$pdf->setPaper('A4','landscape');
    return $pdf->download("catatan_{$month}_{$year}.pdf");
        
    }



public function exportPerUser(Request $request)
{
    $id = $request->user_id ?? auth()->id();
    $user = User::findOrFail($id);

    $catatans = Catatan::where('user_id', $user->id)->get();

    if ($catatans->isEmpty()) {
        // INI BENAR, karena route() akan panggil index()
        return redirect()->route('admin.catatans.index')->with('error', 'Data tidak ditemukan.');
    }

    $pdf = Pdf::loadView('pages.catatans.export_user', compact('catatans', 'user'));
$pdf->setPaper('A4','landscape');

    return $pdf->download("catatan_{$user->name}.pdf");
}


}