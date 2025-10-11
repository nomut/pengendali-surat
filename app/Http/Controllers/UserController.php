<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('users/Index', [
            'users' => User::paginate(10)->through(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'role_name' => $user->role_name,
                'role_id' => $user->role_id,
            ]),
        ]);
    }

    public function create()
    {
        // Method ini akan merender halaman Vue yang baru kita buat
        return Inertia::render('users/Create', [
            'roles' => Role::select('id', 'name')->orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required|exists:roles,id', // Sesuaikan dengan roles Anda
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        
        $user->assignRole([$request->role_id]);

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render('users/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_name' => $user->role_name,
                'role_id' => $user->role_id,
            ],
            'roles' => Role::select('id', 'name')->orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $user->syncRoles([$request->role_id]);

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        if($user->id === 1) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus pengguna ini.');
        }

        $user->delete();

        return redirect()->route('users.index');
    }
    
}