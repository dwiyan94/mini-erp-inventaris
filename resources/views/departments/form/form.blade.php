<div class="modal inmodal" id="departmentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalTitle">Tambah Departemen</h4>
            </div>
            <form id="departmentForm" method="POST" class="form-horizontal">
                @csrf
                <div id="methodField"></div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Departemen</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="departmentName" class="form-control" placeholder="Contoh: Human Resources" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Deskripsi Departemen</label>
                        <div class="col-sm-9">
                            <textarea name="description" id="description" class="form-control" placeholder="Masukkan deskripsi ...">{{ old('description', $department->description ?? '') }}</textarea>
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