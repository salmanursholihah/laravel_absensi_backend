<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return view('pages.calendar'); // resources/views/calendar.blade.php
    }

    /**
     * Ambil semua event untuk calendar.
     * Akan dipanggil oleh FullCalendar via AJAX.
     */
    public function fetchEvents()
    {
        $events = Event::select('id', 'title', 'start', 'end')->get();
        return response()->json($events);
    }

    /**
     * Simpan event baru (via AJAX).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end'   => 'nullable|date'
        ]);

        $event = Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end'   => $request->end,
        ]);

        return response()->json($event);
    }
}