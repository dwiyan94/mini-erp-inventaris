<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Nama User</th>
                <th>Email</th>
                <th>Pekerja Terkait</th>
                <th>Role</th>
                @canany(['edit-users', 'delete-users'])
                <th width="20%" class="text-center">Aksi</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse($users as $key => $user)
            <tr>
                <td class="text-center">{{ $users->firstItem() + $key }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->employee->name ?? '-' }}</td>
                <td>
                    @foreach($user->getRoleNames() as $role)
                        <span class="label label-primary">{{ ucfirst($role) }}</span>
                    @endforeach
                </td>
 
                @canany(['edit-users', 'delete-users'])
                <td class="text-center">
                    <button type="button" class="btn btn-warning btn-xs" onclick='openEditModal(
                        "{{ $user->id }}", 
                        "{{ $user->employee_id }}", 
                        "{{ $user->name }}", 
                        "{{ $user->email }}", 
                        @json($user->roles->pluck('name'))
                    )'>
                        <i class="fa fa-pencil"></i> Edit
                    </button>

                    @can('delete-users')
                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete('{{ $user->id }}')">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                    @endcan
                    
                </td>
                @endcanany

            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data user.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-sm-6 text-left" style="padding-top: 7px;">
        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
    </div>
    <div class="col-sm-6 text-right">
        {{ $users->links() }}
    </div>
</div>