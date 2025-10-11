<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('users/roles/Index', [
            'roles' => Role::withCount('users')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('users/roles/Create', [
            'permissions' => config('permission.abilities'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'in:' . implode(',', array_keys(config('permission.abilities'))),
        ]);

        $role = Role::create(['name' => $request->name]);
        foreach($request->permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('users.roles.index');
    }

    public function edit(Role $role)
    {
        // Muat permission yang sudah dimiliki oleh peran ini
        $role->load('permissions');

        return Inertia::render('users/roles/Edit', [
            'role' => $role,
            'permissions' => config('permission.abilities'),
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($role->id)
            ],
            'permissions' => 'array',
            'permissions.*' => 'in:' . implode(',', array_keys(config('permission.abilities'))),
        ]);

        // 3. Update nama peran
        $role->update([
            'name' => $request->name
        ]);

        // 4. Pastikan semua permission ada (sama seperti di store)
        foreach($request->permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // 5. Sync permissions. Ini akan menghapus yang lama dan menambah yang baru.
        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            // Jika tidak ada permission yang dipilih, hapus semua permission yang ada
            $role->syncPermissions([]);
        }

        return redirect()->route('users.roles.index');
    }

    public function destroy(Role $role)
    {
        if($role->id === 1) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus pengguna ini.');
        }

        if ($role->users_count > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus peran yang masih digunakan oleh pengguna.');
        }

        $role->delete();

        return redirect()->route('users.roles.index');
    }
}
