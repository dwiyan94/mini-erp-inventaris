<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th width="10%" class="text-center">No</th>
                <th class="text-center">Nama Departemen</th>
                <th width="20%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $key => $department)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>

                <td>
                    <a href="{{ route('departments.show', $department->id) }}" style="color: inherit; text-decoration: none;" title="Klik untuk melihat detail">
                        {{ $department->name }}
                    </a>
                </td>

                @canany(['edit-departments', 'delete-departments'])
                <td class="text-center">
                    <button type="button" class="btn btn-warning btn-xs" onclick="openEditModal('{{ $department->id }}', '{{ $department->name }}')">
                        <i class="fa fa-pencil"></i> Edit
                    </button>

                    @can('delete-departments')
                    <form id="delete-form-{{ $department->id }}" action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete('{{ $department->id }}')">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                    @endcan
                </td>
                @endcanany

            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Belum ada data departemen.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Baris Informasi & Paginasi -->
<div class="row" style="margin-top: 15px;">
    <div class="col-sm-6 text-left" style="padding-top: 7px;">
        Showing {{ $departments->firstItem() ?? 0 }} to {{ $departments->lastItem() ?? 0 }} of {{ $departments->total() }} entries
    </div>
    <div class="col-sm-6 text-right">
        {{ $departments->links() }}
    </div>
</div>