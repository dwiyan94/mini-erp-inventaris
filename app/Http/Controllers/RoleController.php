<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view-users')) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }
        
        $search = $request->input('search');

        // Mengambil data role beserta relasi permissions
        $roles = Role::with('permissions')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'ilike', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Mengambil seluruh permissions untuk pilihan di modal form
        $permissions = Permission::all();

        return view('roles.index.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        // Mencegah penghapusan role bawaan yang krusial
        if (!auth()->user()->can('delete-roles')) {
            abort(403, 'Anda tidak memiliki hak akses.');
        }

        if (in_array($role->name, ['admin', 'hr', 'employee'])) {
            return redirect()->route('roles.index')->with('error', 'Role sistem utama tidak dapat dihapus.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }
}