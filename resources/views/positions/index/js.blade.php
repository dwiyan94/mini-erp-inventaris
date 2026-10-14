<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right",
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "4000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        @if(session('success'))
            toastr.success('{{ session('success') }}', 'Berhasil!');
        @endif
    });

    function confirmDelete(id) {
        swal({
            title: "Apakah Anda yakin?",
            text: "Data posisi yang dihapus akan masuk ke sampah!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                document.getElementById('delete-form-' + id).submit();
                swal("Terhapus!", "Data yang anda pilih telah terhapus.", "success");
            } else {
                swal("Batal", "Data yang akan dihapus dibatalkan :)", "error");
            }            
        });
    }

    function openCreateModal() {
        $('#modalTitle').text('Tambah Posisi');
        $('#modalSubmitBtn').text('Simpan');
        $('#positionForm').attr('action', '{{ route("positions.store") }}');
        $('#departmentId').val('');
        $('#positionName').val('');
        $('#task').val('');
        $('#methodField').html('');
        $('#positionModal').modal('show');
    }

    function openEditModal(id, departmentId, name, task) {
        $('#modalTitle').text('Edit Posisi');
        $('#modalSubmitBtn').text('Perbarui');
        
        let updateUrl = '{{ route("positions.update", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);
        $('#positionForm').attr('action', updateUrl);
        
        $('#departmentId').val(departmentId);
        $('#positionName').val(name);
        $('#task').val(task);
        $('#methodField').html('<input type="hidden" name="_method" value="PUT">');
        $('#positionModal').modal('show');
    }
</script>