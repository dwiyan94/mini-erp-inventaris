<script>
    $(document).ready(function() {
        @if($errors->any())
            $('#positionForm').modal('show');
        @endif
    });

    $(document).ready(function() {
        $('.chosen-select').chosen({
            width: "100%",
            no_results_text: "Data tidak ditemukan: ",
            allow_single_deselect: true
        });

        $('#positionModal').on('shown.bs.modal', function () {
            $('.chosen-select').trigger('chosen:updated');
        });
    });

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
        
        $('#departmentId').val(departmentId).trigger('chosen:updated');
        $('#positionName').val(name);
        $('#task').val(task);
        $('#methodField').html('<input type="hidden" name="_method" value="PUT">');
        $('#positionModal').modal('show');
    }
</script>