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

        @if(session('error'))
            toastr.error('{{ session('error') }}', 'Gagal!');
        @endif

        @if($errors->any())
            toastr.error('Terjadi kesalahan. Periksa kembali input data Anda.', 'Validasi Gagal!');
            
            $('#userModal').modal('show');
        @endif
    });

    function confirmDelete(id) {
        swal({
            title: "Apakah Anda yakin?",
            text: "Data user yang dihapus tidak dapat dikembalikan!",
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
        $('#modalTitle').text('Tambah Data Baru');
        $('#modalSubmitBtn').text('Simpan');
        $('#userForm').attr('action', '{{ route("users.store") }}');
        
        // Reset form input...
        $('#userForm')[0].reset();
        $('#userRole').val('').trigger('chosen:updated');
        $('#employeeId').val('').trigger('chosen:updated');
        
        $('#methodField').html('');
        $('#userModal').modal('show');
    }

    function openEditModal(id, employeeId, name, email, rolesArray) {
        $('#modalTitle').text('Edit Data Akun');
        $('#modalSubmitBtn').text('Perbarui');
        
        let updateUrl = '{{ route("users.update", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);
        $('#userForm').attr('action', updateUrl);
        
        $('#employeeId').val(employeeId).trigger('chosen:updated');
        $('#userName').val(name);
        $('#userEmail').val(email);
        $('#userPassword').val('');
        
        $('#userRole').val(rolesArray).trigger('chosen:updated');
        
        $('#methodField').html('<input type="hidden" name="_method" value="PUT">');
        $('#userModal').modal('show');
    }

    $(document).ready(function() {
        $('.chosen-select').chosen({
            width: "100%",
            no_results_text: "Data tidak ditemukan: ",
            allow_single_deselect: true
        });

        $('#userModal').on('shown.bs.modal', function () {
            $('.chosen-select').trigger('chosen:updated');
        });
    });

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('userPassword');
        const passwordIcon = document.getElementById('togglePasswordIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash'); 
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye'); 
        }
    }


</script>