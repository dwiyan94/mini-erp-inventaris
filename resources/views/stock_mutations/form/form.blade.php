<div class="modal inmodal" id="mutationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
                <h4 class="modal-title">Form Mutasi Stok Produk</h4>
            </div>
            <form action="{{ route('stock_mutations.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal" id="mutationForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pilih Produk</label>
                        <div class="col-sm-9">
                            <select name="product_id" id="productSelect" class="form-control chosen-select" required>
                                <option value="">-- Cari / Pilih Produk --</option>
                                @foreach(\App\Models\Product::all() as $product)
                                    <!-- Tambahkan atribut data-stock untuk menyimpan sisa stok produk -->
                                    <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        [{{ $product->sku }}] {{ $product->name }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tipe Transaksi</label>
                        <div class="col-sm-9">
                            <label class="radio-inline" style="margin-right: 20px; cursor: pointer;">
                                <input type="radio" name="type" id="typeIn" value="in" {{ old('type', 'in') == 'in' ? 'checked' : '' }} required> 
                                <span class="label label-primary" style="background-color: #1ab394; padding: 4px 10px; font-size: 12px;">
                                    <i class="fa fa-arrow-down"></i> MASUK (IN)
                                </span>
                            </label>

                            <label class="radio-inline" style="cursor: pointer;">
                                <input type="radio" name="type" id="typeOut" value="out" {{ old('type') == 'out' ? 'checked' : '' }} required> 
                                <span class="label label-danger" style="background-color: #ed5565; padding: 4px 10px; font-size: 12px;">
                                    <i class="fa fa-arrow-up"></i> KELUAR (OUT)
                                </span>
                            </label>
                        </div>
                        @error('type')
                            <span class="text-danger" style="font-size: 11px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jumlah (Qty)</label>
                        <div class="col-sm-9">
                            <input type="number" 
                                   name="quantity" 
                                   id="quantity" 
                                   class="form-control" 
                                   min="1" 
                                   step="1" 
                                   oninput="this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(Math.floor(this.value)) : null" 
                                   placeholder="Masukkan angka bulat..." 
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Catatan / Alasan</label>
                        <div class="col-sm-9">
                            <textarea name="notes" id="notes" class="form-control" placeholder="Contoh: Restock gudang / Pengiriman pesanan klien..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bukti Foto (Opsional)</label>
                        <div class="col-sm-9">
                            <input type="file" name="photo" class="form-control">
                            <span class="help-block m-b-none text-muted"><small>Format: JPG, PNG, WEBP (Maks. 2MB)</small></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pratinjau Gambar (Pop-up) -->
<div class="modal inmodal" id="imagePreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
                <h4 class="modal-title">Pratinjau Foto Bukti Mutasi</h4>
            </div>
            <div class="modal-body text-center" style="background-color: #f9f9f9; padding: 15px;">
                <!-- Gambar yang akan dimuat secara dinamis -->
                <img id="modalImagePreview" src="" alt="Bukti Mutasi" style="max-width: 100%; height: auto; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Mutasi -->
<div class="modal inmodal" id="mutationDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header" style="background-color: #1ab394; color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white;"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> Detail Mutasi Stok</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 35%; background-color: #f9f9f9;">Tanggal & Waktu</th>
                        <td id="det-created-at"></td>
                    </tr>
                    <tr>
                        <th style="background-color: #f9f9f9;">SKU & Nama Barang</th>
                        <td><strong id="det-product-name"></strong><br><small class="text-muted" id="det-product-sku"></small></td>
                    </tr>
                    <tr>
                        <th style="background-color: #f9f9f9;">Tipe Mutasi</th>
                        <td id="det-type"></td>
                    </tr>
                    <tr>
                        <th style="background-color: #f9f9f9;">Jumlah (Qty)</th>
                        <td id="det-quantity"></td>
                    </tr>
                    <tr>
                        <th style="background-color: #f9f9f9;">Stok Sebelum -> Sesudah</th>
                        <td><span id="det-stock-before"></span> -> <strong class="text-navy" id="det-stock-after"></strong></td>
                    </tr>
                    <tr>
                        <th style="background-color: #f9f9f9;">Petugas</th>
                        <td id="det-user"></td>
                    </tr>
                    <tr>
                        <th style="background-color: #f9f9f9;">Catatan</th>
                        <td id="det-notes"></td>
                    </tr>
                    <tr>
                        <th style="background-color: #f9f9f9;">Foto Bukti</th>
                        <td class="text-center">
                            <div id="det-photo-container">
                                
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>