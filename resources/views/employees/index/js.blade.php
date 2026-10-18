<script>
    $(document).ready(function() {
        // Inisialisasi Plugin Chosen
        $('.chosen-select').chosen({
            width: "100%",
            no_results_text: "Data tidak ditemukan: ",
            allow_single_deselect: true
        });

        // (Opsional) Jika halaman ini ternyata pernah digunakan di dalam modal, 
        // pastikan chosen di-update saat modal terbuka agar ukurannya tidak mengecil.
        $('#userModal').on('shown.bs.modal', function () {
            $('.chosen-select').trigger('chosen:updated');
        });
    });
</script>