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
            text: "Data pekerja yang dihapus akan masuk ke sampah!",
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
</script>