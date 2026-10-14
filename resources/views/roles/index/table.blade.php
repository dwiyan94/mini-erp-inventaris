<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="25%">Nama Role</th>
                <th>Daftar Permissions</th>
                <th width="20%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $key => $role)
            <tr>
                <td class="text-center">{{ $roles->firstItem() + $key }}</td>
                <td><span class="font-bold">{{ strtoupper($role->name) }}</span></td>
                <td>
                    @forelse($role->permissions as $permission)
                        <span class="label label-info" style="margin-right: 3px; display: inline-block; margin-bottom: 3px;">{{ $permission->name }}</span>
                    @empty
                        <span class="text-muted">Tidak ada permission khusus.</span>
                    @endforelse
                </td>

                @canany(['edit-roles', 'delete-roles'])
                <td class="text-center">
                    <button type="button" class="btn btn-warning btn-xs" onclick='openEditModal(
                        "{{ $role->id }}", 
                        "{{ $role->name }}", 
                        @json($role->permissions->pluck('name'))
                    )'>
                        <i class="fa fa-pencil"></i> Edit
                    </button>

                    @if(!in_array($role->name, ['admin', 'hr', 'employee']))
                        @can('delete-roles')
                        <form id="delete-form-{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete('{{ $role->id }}')">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>                    
                        @endcan
                    @endif
                </td>
                @endcanany
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada data role.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Informasi & Paginasi -->
<div class="row" style="margin-top: 15px;">
    <div class="col-sm-6 text-left" style="padding-top: 7px;">
        Showing {{ $roles->firstItem() ?? 0 }} to {{ $roles->lastItem() ?? 0 }} of {{ $roles->total() }} entries
    </div>
    <div class="col-sm-6 text-right">
        {{ $roles->links() }}
    </div>
</div>