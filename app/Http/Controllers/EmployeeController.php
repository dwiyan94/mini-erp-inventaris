<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view-users')) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }
        
        $search = $request->input('search');

        $employees = Employee::with('position.department')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'ilike', '%' . $search . '%')
                             ->orWhere('nik', 'ilike', '%' . $search . '%')
                             ->orWhere('phone', 'ilike', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $positions = Position::with('department')->get();

        return view('employees.index.index', compact('employees', 'positions'));
    }

    public function create()
    {
        $positions = Position::with('department')->get();
        return view('employees.form.form', compact('positions'));
    }

    public function edit(Employee $employee)
    {
        $positions = Position::with('department')->get();
        return view('employees.form.form', compact('employee', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|unique:employees,nik',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'position_id' => 'required|exists:positions,id',
            'join_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/employees'), $filename);
            $data['photo'] = $filename;
        }

        Employee::create($data);

        return redirect()->route('employees.index')->with('success', 'Data pekerja berhasil ditambahkan.');
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'nik' => 'required|string|unique:employees,nik,' . $employee->id,
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'position_id' => 'required|exists:positions,id',
            'join_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($employee->photo && file_exists(public_path('uploads/employees/' . $employee->photo))) {
                unlink(public_path('uploads/employees/' . $employee->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/employees'), $filename);
            $data['photo'] = $filename;
        }

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Data pekerja berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        if (!auth()->user()->can('delete-employess')) {
            abort(403, 'Anda tidak memiliki hak akses.');
        }

        if ($employee->photo && file_exists(public_path('uploads/employees/' . $employee->photo))) {
            unlink(public_path('uploads/employees/' . $employee->photo));
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Data pekerja berhasil dihapus.');
    }
}