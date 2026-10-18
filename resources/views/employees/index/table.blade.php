<div class="table-responsive">
    <table class="table table-stripped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th width="10%" class="text-center">Foto</th>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>No. Handphone</th>
                <th>Posisi & Departemen</th>
                <th>Tanggal Bergabung</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $key => $employee)
            <tr>
                <td class="text-center">{{ $employees->firstItem() + $key }}</td>
                <td class="text-center">
                    @if($employee->photo && file_exists(public_path('uploads/employees/' . $employee->photo)))
                        <img src="{{ asset('uploads/employees/' . $employee->photo) }}" alt="Foto" class="img-circle" width="40" height="40" style="object-fit: cover;">
                    @else
                        <img src="{{ asset('inspinia/img/user.png') }}" alt="Default" class="img-circle" width="40" height="40">
                    @endif
                </td>
                <td>{{ $employee->nik }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->phone ?? '-' }}</td>
                <td>{{ $employee->position->name ?? '-' }}</td>
                <td>
                    {{ date('d F Y', strtotime($employee->join_date)) }}

                </td>
                
                @canany(['edit-employees', 'delete-employees'])
                <td class="text-center">
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-xs">
                        <i class="fa fa-pencil"></i> Edit
                    </a>

                    @can('delete-employees')
                    <form id="delete-form-{{ $employee->id }}" action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE') 
                        <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete('{{ $employee->id }}')">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                    @endcan
                </td>
                @endcanany

            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada data pekerja.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-sm-6 text-left" style="padding-top: 7px;">
        Showing {{ $employees->firstItem() ?? 0 }} to {{ $employees->lastItem() ?? 0 }} of {{ $employees->total() }} entries
    </div>
    <div class="col-sm-6 text-right">
        {{ $employees->links() }}
    </div>
</div>