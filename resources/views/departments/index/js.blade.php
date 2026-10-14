<script>

    $(document).ready(function() {
        // Konfigurasi opsi Toastr (opsional)
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

        // Tangkap pesan sukses dari session Laravel
        @if(session('success'))
            toastr.success('{{ session('success') }}', 'Berhasil!');
        @endif
    });

    function confirmDelete(id) {
        swal({
            title: "Apakah Anda yakin?",
            text: "Data departemen yang dihapus akan masuk ke sampah !",
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
        $('#modalTitle').text('Tambah Departemen');
        $('#modalSubmitBtn').text('Simpan');
        $('#departmentForm').attr('action', '{{ route("departments.store") }}');
        $('#departmentName').val('');
        $('#methodField').html('');
        $('#departmentModal').modal('show');
    }

    function openEditModal(id, name) {
        $('#modalTitle').text('Edit Departemen');
        $('#modalSubmitBtn').text('Perbarui');
        
        let updateUrl = '{{ route("departments.update", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);
        $('#departmentForm').attr('action', updateUrl);
        
        $('#departmentName').val(name);
        $('#methodField').html('<input type="hidden" name="_method" value="PUT">');
        $('#departmentModal').modal('show');
    }
</script>