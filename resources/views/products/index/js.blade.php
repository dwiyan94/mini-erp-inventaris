<script>
    function openCreateModal() {
        $('#modalTitle').text('Tambah Produk Baru');
        $('#modalSubmitBtn').text('Simpan');
        $('#productForm').attr('action', '{{ route("products.store") }}');
        $('#productForm')[0].reset();
        $('#methodField').html('');
        $('#stockGroup').show();
        $('#stock').prop('required', true);
        // Sembunyikan pratinjau foto saat tambah baru
        $('#photoPreviewContainer').hide();
        $('#previewPhoto').attr('src', '');
        $('#productModal').modal('show');
    }

    // URUTAN PARAMETER HARUS KONSISTEN
    function openEditModal(id, sku, name, category, unit, price, stock, photo) {
        $('#modalTitle').text('Edit Produk');
        $('#modalSubmitBtn').text('Perbarui');
        
        let updateUrl = '{{ route("products.update", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);
        $('#productForm').attr('action', updateUrl);
        
        $('#sku').val(sku);
        $('#name').val(name);
        $('#category').val(category);
        $('#unit').val(unit);
        
        let cleanPrice = Math.floor(parseFloat(price) || 0);
        $('#price').val(cleanPrice);

        $('#stockGroup').hide();
        $('#stock').prop('required', false);

        // Tampilkan pratinjau foto jika ada
        if (photo && photo !== 'null' && photo !== '' && photo !== 'undefined') {
            let photoUrl = '{{ asset("uploads/products/items") }}/' + photo;
            $('#previewPhoto').attr('src', photoUrl);
            $('#photoPreviewContainer').show();
        } else {
            $('#photoPreviewContainer').hide();
            $('#previewPhoto').attr('src', '');
        }

        $('#methodField').html('<input type="hidden" name="_method" value="PUT">');
        $('#productModal').modal('show');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const priceInput = document.getElementById('price');

        if (priceInput) {
            priceInput.addEventListener('input', function (e) {
                let value = this.value.replace(/[^0-9]/g, '');
                
                if (value === '0' || value === '') {
                    this.value = '';
                    return;
                }
                

                if (value) {
                    value = parseInt(value, 10).toLocaleString('id-ID');
                }
                
                this.value = value;
            });
        }

        $('#productForm').on('submit', function(e) {
            let rawPrice = $('#price').val().replace(/\./g, '');
            
            if (!rawPrice || parseInt(rawPrice) <= 0) {
                alert('Harga produk harus lebih dari 0!');
                $('#price').focus();
                e.preventDefault(); // Batalkan pengiriman form
                return false;
            }
            
            $('#price').val(rawPrice);
        });
    });

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

    // Konfirmasi untuk Muat Data Demo dengan SweetAlert
        function confirmImportDemo(event, element) {
            event.preventDefault(); // Mencegah langsung pindah halaman
            
            swal({
                title: "Muat Data Demo?",
                text: "Sistem akan mengambil data produk demo terbaru dari server.",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#1ab394", // Warna hijau khas Inspinia
                confirmButtonText: "Ya, Muat Data!",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (isConfirm) {
                    // Arahkan ke URL import demo
                    window.location.href = element.href;
                }
            });
        }

        // Konfirmasi untuk Reset Data dengan SweetAlert
        function confirmResetDemo(event, element) {
            event.preventDefault(); // Mencegah langsung pindah halaman

            swal({
                title: "Apakah Anda yakin mereset data?",
                text: "Semua data produk dan riwayat mutasi stok akan dikosongkan secara total!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55", // Warna merah peringatan
                confirmButtonText: "Ya, Reset Total!",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (isConfirm) {
                    // Arahkan ke URL reset demo
                    window.location.href = element.href;
                }
            });
        }

    // function showImportToast(event, element) {
    //         event.preventDefault(); // Mencegah pindah halaman langsung sebentar untuk menampilkan toast
            
    //         // Konfigurasi Toastr
    //         toastr.options = {
    //             "closeButton": true,
    //             "progressBar": true,
    //             "positionClass": "toast-top-right",
    //             "timeOut": "3000"
    //         };
            
    //         toastr.info('Sedang mengambil data demo dari server, mohon tunggu...', 'Memproses Data');

    //         // Beri jeda sedikit agar toast sempat tampil sebelum berpindah halaman
    //         setTimeout(function() {
    //             window.location.href = element.href;
    //         }, 1000);
    //     }

    //     function showResetToast(event, element) {
    //         event.preventDefault();

    //         // Konfirmasi konvensional atau langsung toast peringatan
    //         if (confirm('Apakah Anda yakin ingin mereset seluruh data produk dan mutasi?')) {
    //             toastr.options = {

    //                 "showCancelButton": true,
    //                 "confirmButtonColor": "#DD6B55",
    //                 "confirmButtonText": "Ya, hapus!",
    //                 "cancelButtonText": "Batal",
    //                 "closeOnConfirm": false,
    //                 "closeOnCancel": false
    //             };
                
    //             toastr.warning('Sedang membersihkan database...', 'Mereset Data');

    //             setTimeout(function() {
    //                 window.location.href = element.href;
    //             }, 1000);
    //         }
    //     }
</script>