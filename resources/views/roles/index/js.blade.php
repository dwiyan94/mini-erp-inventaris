<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "4000",
        }

        @if(session('success'))
            toastr.success('{{ session('success') }}', 'Berhasil!');
        @endif

        @if(session('error'))
            toastr.error('{{ session('error') }}', 'Gagal!');
        @endif

        @if($errors->any())
            toastr.error('Terjadi kesalahan. Periksa kembali input data Anda.', 'Validasi Gagal!');
            $('#roleModal').modal('show');
        @endif

        // Inisialisasi Plugin Chosen
        $('.chosen-select').chosen({
            width: "100%",
            no_results_text: "Data tidak ditemukan: ",
            allow_single_deselect: true
        });

        $('#roleModal').on('shown.bs.modal', function () {
            $('.chosen-select').trigger('chosen:updated');
        });
    });

    function confirmDelete(id) {
        swal({
            title: "Apakah Anda yakin?",
            text: "Data role yang dihapus tidak dapat dikembalikan!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        }, function () {
            document.getElementById('delete-form-' + id).submit();
        });
    }

    function openCreateModal() {
        $('#modalTitle').text('Tambah Role Baru');
        $('#modalSubmitBtn').text('Simpan');
        $('#roleForm').attr('action', '{{ route("roles.store") }}');
        
        $('#roleName').val('');
        $('#rolePermissions').val('').trigger('chosen:updated');
        
        $('#methodField').html('');
        $('#roleModal').modal('show');
    }

    function openEditModal(id, name, permissionsArray) {
        $('#modalTitle').text('Edit Data Role');
        $('#modalSubmitBtn').text('Perbarui');
        
        let updateUrl = '{{ route("roles.update", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);
        $('#roleForm').attr('action', updateUrl);
        
        $('#roleName').val(name);
        $('#rolePermissions').val(permissionsArray).trigger('chosen:updated');
        
        $('#methodField').html('<input type="hidden" name="_method" value="PUT">');
        $('#roleModal').modal('show');
    }
</script>