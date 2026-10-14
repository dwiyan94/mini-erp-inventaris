<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view-users')) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }
        
        $search = $request->input('search');

        // Mengambil data user beserta relasi employee dan roles
        $users = User::with(['employee', 'roles'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'ilike', '%' . $search . '%')
                             ->orWhere('email', 'ilike', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Data pendukung untuk pilihan di modal (Employee dan Roles)
        $employees = Employee::all();
        $roles = Role::all();

        return view('users.index.index', compact('users', 'employees', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required', 
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user = User::create([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Berikan banyak role sekaligus
        $user->assignRole($request->roles);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        // Aturan dasar validasi
        $rules = [
            'employee_id' => 'nullable|exists:employees,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ];

        // Jika kolom password diisi oleh user, baru terapkan aturan keamanan ketat
        if ($request->filled('password')) {
            $rules['password'] = [
                'required',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ];
        }

        $request->validate($rules);

        // Siapkan data yang akan diupdate
        $data = [
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        // Sinkronisasi multi-role
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->can('delete-users')) {
            abort(403, 'Anda tidak memiliki hak akses.');
        }
        
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function profile()
    {
        // Mengambil user yang sedang login saat ini beserta relasinya
        $user = auth()->user()->load([
            'employee.position.department', 
            'roles.permissions'
        ]);

        return view('users.profile', compact('user'));
    }
}