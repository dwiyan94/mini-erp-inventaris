<div class="modal inmodal" id="roleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalTitle">Tambah Role</h4>
            </div>
            <form id="roleForm" method="POST" class="form-horizontal">
                @csrf
                <div id="methodField"></div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Role</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="roleName" class="form-control" placeholder="Contoh: manager, finance" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Hak Akses (Permissions)</label>
                        <div class="col-sm-9">
                            <select name="permissions[]" id="rolePermissions" class="chosen-select form-control" data-placeholder="-- Pilih Hak Akses (Bisa Lebih dari Satu) --" multiple>
                                @foreach($permissions as $perm)
                                    <option value="{{ $perm->name }}">{{ $perm->name }}</option>
                                @endforeach
                            </select>
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