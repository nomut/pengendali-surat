<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('meetings/Index', [
            'meetings' => Meeting::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('meetings/Create', [
            'persons' => Person::all(['id', 'name', 'office', 'email']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'location' => 'required|string|max:255',
            'minutes' => 'nullable|string',
            'pesertas' => 'nullable|array',
            'pesertas.*' => 'exists:people,id',
        ]);

        $meeting = Meeting::create($request->except('pesertas'));

        if ($request->filled('pesertas')) {
            $meeting->person()->sync($request->pesertas);
        }

        return Redirect::route('meetings.index')->with('success', 'Data rapat baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meeting $meeting)
    {
        // Muat relasi 'pesertas' agar datanya bisa diakses di frontend
        $meeting->load('person');

        return Inertia::render('meetings/Show', [
            'meeting' => $meeting
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meeting $meeting)
    {
        // Muat relasi 'person' agar data peserta terkirim ke frontend
        $meeting->load('person');
        
        return Inertia::render('meetings/Edit', [
            'meeting' => $meeting,
            'persons' => Person::all(['id', 'name', 'office', 'email']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'location' => 'required|string|max:255',
            'minutes' => 'nullable|string',
            'pesertas' => 'required|array|min:1',
            'pesertas.*' => 'exists:people,id',
        ]);

        // Update field utama pada rapat
        $meeting->update($request->except('pesertas'));

        // Sinkronkan peserta. Ini akan menghapus yang lama dan menambah yang baru.
        if ($request->filled('pesertas')) {
            $meeting->person()->sync($request->pesertas);
        } else {
            // Jika tidak ada peserta yang dipilih, hapus semua relasi peserta.
            $meeting->person()->sync([]);
        }

        return Redirect::route('meetings.index')->with('success', 'Data rapat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return Redirect::route('meetings.index')->with('success', 'Data rapat berhasil dihapus.');
    }
}
