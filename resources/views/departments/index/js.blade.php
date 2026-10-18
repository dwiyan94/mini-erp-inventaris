<script>
    $(document).ready(function() {
        @if($errors->any())
            $('#departmentModal').modal('show');
        @endif
    });
    
    function openCreateModal() {
        $('#modalTitle').text('Tambah Departemen');
        $('#modalSubmitBtn').text('Simpan');
        $('#departmentForm').attr('action', '{{ route("departments.store") }}');
        $('#departmentName').val('');
        $('#description').val('');
        $('#methodField').html('');
        $('#departmentModal').modal('show');
    }

    function openEditModal(id, name, description) {
        $('#modalTitle').text('Edit Departemen');
        $('#modalSubmitBtn').text('Perbarui');
        
        let updateUrl = '{{ route("departments.update", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);
        $('#departmentForm').attr('action', updateUrl);
        
        $('#departmentName').val(name);
        $('#description').val(description);
        $('#methodField').html('<input type="hidden" name="_method" value="PUT">');
        $('#departmentModal').modal('show');
    }
</script>