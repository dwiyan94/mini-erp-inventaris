<div class="table-responsive">
    <table class="table table-stripped table-hover">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th width="15%">Departemen</th>
                <th width="20%">Nama Posisi</th>
                <th>Deskripsi Tugas</th>
                <th width="10%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($positions as $key => $position)
            <tr>
                <td class="text-center">{{ $positions->firstItem() + $key }}</td>
                <td>{{ $position->department->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('positions.show', $position->id) }}" style="color: inherit; text-decoration: none;" title="Klik untuk melihat daftar pekerja">
                        <span style="border-bottom: 1px;">{{ $position->name }}</span>
                    </a>
                </td>

                <td>
                    {{ $position->task }}
                </td>

                @canany(['edit-positions', 'delete-positions'])
                <td class="text-center">
                    <button type="button" class="btn btn-warning btn-xs" onclick="openEditModal('{{ $position->id }}', '{{ $position->department_id }}', '{{ $position->name }}', '{{ $position->task }}')">
                        <i class="fa fa-pencil"></i> Edit
                    </button>

                    @can('delete-positions')
                    <form id="delete-form-{{ $position->id }}" action="{{ route('positions.destroy', $position->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete('{{ $position->id }}')">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                    @endcan
                </td>
                @endcanany

            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada data posisi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Baris Informasi & Paginasi -->
<div class="row" style="margin-top: 15px;">
    <div class="col-sm-6 text-left" style="padding-top: 7px;">
        Showing {{ $positions->firstItem() ?? 0 }} to {{ $positions->lastItem() ?? 0 }} of {{ $positions->total() }} entries
    </div>
    <div class="col-sm-6 text-right">
        {{ $positions->links() }}
    </div>
</div>