<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view-users')) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }
        
        $search = $request->input('search');

        // Mengambil data posisi beserta relasi departemen dengan paginasi dan pencarian
        $positions = Position::with('department')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'ilike', '%' . $search . '%')
                             ->orWhereHas('department', function ($q) use ($search) {
                                 $q->where('name', 'ilike', '%' . $search . '%');
                             });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Mengirim data departments untuk pilihan select di modal form
        $departments = Department::all();

        return view('positions.index.index', compact('positions', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'task' => 'nullable|string',
        ]);

        Position::create($request->all());

        return redirect()->route('positions.index')->with('success', 'Posisi berhasil ditambahkan.');
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'task' => 'nullable|string',
        ]);

        $position->update($request->all());

        return redirect()->route('positions.index')->with('success', 'Posisi berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        if (!auth()->user()->can('delete-positions')) {
            abort(403, 'Anda tidak memiliki hak akses.');
        }

        $position->delete();

        return redirect()->route('positions.index')->with('success', 'Posisi berhasil dihapus.');
    }

    public function show(Position $position)
    {
        // Memuat relasi departemen dan pekerja yang terikat pada posisi ini
        $position->load('department', 'employees');

        return view('positions.single.index', compact('position'));
    }
}