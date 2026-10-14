<script>
    function openMutationModal() {
        $('#mutationModal').find('form')[0].reset();
        $('#mutationModal').modal('show');
    }

    function showImageModal(imageUrl) {
        $('#modalImagePreview').attr('src', imageUrl);
        $('#imagePreviewModal').modal('show');
    }

    function showDetailMutation(url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    let d = response.data;
                    
                    // Isi data ke elemen modal
                    $('#det-created-at').text(d.created_at);
                    $('#det-product-name').text(d.product_name);
                    $('#det-product-sku').text(d.product_sku);
                    
                    let badgeType = d.type === 'in' 
                        ? '<span class="label label-primary" style="background-color: #1ab394;">MASUK (IN)</span>' 
                        : '<span class="label label-danger" style="background-color: #ed5565;">KELUAR (OUT)</span>';
                    $('#det-type').html(badgeType);
                    
                    $('#det-quantity').text(d.quantity);
                    $('#det-stock-before').text(d.stock_before);
                    $('#det-stock-after').text(d.stock_after);
                    $('#det-user').text(d.user_name);
                    $('#det-notes').text(d.notes);
                    
                    // Render Foto Bukti
                    let photoHtml = '';
                    if(d.photo_url) {
                        photoHtml = `<a href="javascript:void(0);" onclick="showImageModal('${d.photo_url}')" title="Klik untuk memperbesar">
                                        <img src="${d.photo_url}" class="img-thumbnail" style="max-height: 120px; object-fit: cover; border-radius: 4px;">
                                     </a>`;
                    } else {
                        photoHtml = '<span class="text-muted"><i>Tidak ada foto bukti</i></span>';
                    }
                    $('#det-photo-container').html(photoHtml);
                    
                    // Tampilkan modal
                    $('#mutationDetailModal').modal('show');
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Gagal mengambil data detail mutasi.');
            }
        });
    }

    $(document).ready(function() {
            $('.chosen-select').chosen({
                width: "100%",
                no_results_text: "Produk tidak ditemukan: "
            });

            // Validasi form saat disubmit
            $('#mutationForm').on('submit', function(e) {
                let selectedOption = $('#productSelect').find('option:selected');
                let currentStock = parseInt(selectedOption.attr('data-stock')) || 0;
                let qty = parseInt($('#quantity').val()) || 0;
                let type = $('input[name="type"]:checked').val();

                // Jika tipe transaksi adalah 'out' dan quantity melebihi stok
                if (type === 'out' && qty > currentStock) {
                    e.preventDefault(); // Batalkan submit form
                    
                    // Munculkan peringatan Toastr (atau alert biasa jika Toastr belum terpasang)
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Jumlah keluar (' + qty + ') melebihi sisa stok saat ini (' + currentStock + ')!', 'Stok Tidak Mencukupi');
                    } else {
                        alert('Gagal! Jumlah keluar (' + qty + ') melebihi sisa stok saat ini (' + currentStock + ').');
                    }
                    
                    $('#quantity').focus();
                }
            });
        });


        
</script>

