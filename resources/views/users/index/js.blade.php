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

        // 1. Notifikasi Sukses
        @if(session('success'))
            toastr.success('{{ session('success') }}', 'Berhasil!');
        @endif

        // 2. Notifikasi Error Umum (Session Error)
        @if(session('error'))
            toastr.error('{{ session('error') }}', 'Gagal!');
        @endif

        // 3. Notifikasi Error Validasi Laravel & Otomatis Buka Modal Kembali
        @if($errors->any())
            toastr.error('Terjadi kesalahan. Periksa kembali input data Anda.', 'Validasi Gagal!');
            
            // Otomatis membuka kembali modal jika terjadi error validasi saat Store / Update
            // (Ganti #userModal dengan ID modal yang sesuai, misal #positionModal atau #departmentModal)
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
        // 1. Inisialisasi plugin Chosen dengan lebar 100%
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
            passwordIcon.classList.add('fa-eye-slash'); // Ubah ikon menjadi mata tertutup/dicoret
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye'); // Ubah kembali ikon menjadi mata terbuka
        }
    }


</script>