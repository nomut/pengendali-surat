<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PersonController extends Controller
{
    public function index()
    {
        return Inertia::render('persons/Index', [
            'persons' => Person::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'office' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        $person = Person::create($validated);

        return response()->json($person);
    }

    public function edit(Person $person)
    {
        return Inertia::render('persons/Edit', [
            'person' => $person,
        ]);
    }

    public function update(Request $request, Person $person)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'office' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        $person->update($validated);

        return Redirect::route('persons.index')->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy(Person $person)
    {
        $person->delete();
        return Redirect::route('persons.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}