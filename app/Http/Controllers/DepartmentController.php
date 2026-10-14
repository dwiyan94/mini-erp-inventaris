<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view-users')) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        $search = $request->input('search');

        $departments = Department::when($search, function ($query, $search) {
                return $query->where('name', 'ilike', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(25) 
            ->withQueryString(); 

        return view('departments.index.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Department::create($request->all());
        return redirect()->route('departments.index')->with('success', 'Data Departemen berhasil ditambahkan.');
    }

    public function update(Request $request, Department $department)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $department->update($request->all());
        return redirect()->route('departments.index')->with('success', 'Data Departemen berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        if (!auth()->user()->can('delete-departments')) {
            abort(403, 'Anda tidak memiliki hak akses.');
        }

        $department->delete(); 
        return redirect()->route('departments.index')->with('success', 'Data Departemen berhasil dihapus.');
    }

    public function show(Department $department)
    {
        $department->load('positions');

        return view('departments.single.index', compact('department'));
    }
}
