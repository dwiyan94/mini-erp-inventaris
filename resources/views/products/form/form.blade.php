<div class="modal inmodal" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
                <h4 class="modal-title" id="modalTitle">Tambah Produk Baru</h4>
            </div>
            <form id="productForm" method="POST" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                <div id="methodField"></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">SKU / Kode</label>
                        <div class="col-sm-9">
                            <input type="text" name="sku" id="sku" class="form-control" placeholder="Contoh: PRD-001" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Produk</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama barang..." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kategori</label>
                        <div class="col-sm-9">
                            <input type="text" name="category" id="category" class="form-control" placeholder="Contoh: Elektronik / Bahan Baku" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Satuan Unit</label>
                        <div class="col-sm-9">
                            <input type="text" name="unit" id="unit" class="form-control" placeholder="Contoh: Pcs / Kg / Box" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Harga (Rp)</label>
                        <div class="col-sm-9">
                            
                            <!-- Ubah type="number" menjadi type="text" agar bisa menampilkan titik pemisah -->
                            <input type="text" 
                                   name="price" 
                                   id="price" 
                                   class="form-control"
                                   placeholder="Contoh: 5.099.830" 
                                   required>
                        </div>

                    </div>
                    <div class="form-group" id="stockGroup">
                        <label class="col-sm-3 control-label">Stok Awal</label>
                        <div class="col-sm-9">
                            <input type="number" 
                                   name="stock" 
                                   id="stock" 
                                   class="form-control" 
                                   min="1" 
                                   step="1" 
                                   oninput="this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(Math.floor(this.value)) : null" 
                                   placeholder="Masukkan angka bulat..." 
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Foto Produk</label>
                        <div class="col-sm-9">
                            <!-- Tambahkan elemen ini untuk menampilkan pratinjau foto saat edit -->
                            <div id="photoPreviewContainer" style="margin-bottom: 10px; display: none;">
                                <img id="previewPhoto" src="" alt="Pratinjau Foto" class="img-thumbnail" style="max-height: 100px;">
                                <p class="text-muted text-xs m-t-xs">Foto saat ini. Pilih file baru di bawah jika ingin mengubahnya.</p>
                            </div>

                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <span class="help-block m-b-none text-muted"><small>Format: JPG, PNG, WEBP (Maks. 2MB)</small></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="modalSubmitBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

