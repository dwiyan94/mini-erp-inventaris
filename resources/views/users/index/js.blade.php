<script>
    $(document).ready(function() {
        // Hanya buka userModal jika ada error di halaman User
        @if($errors->any())
            $('#userModal').modal('show');
        @endif
    });

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