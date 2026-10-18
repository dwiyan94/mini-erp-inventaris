<div class="modal inmodal" id="positionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalTitle">Tambah Posisi</h4>
            </div>
            <form id="positionForm" method="POST" class="form-horizontal">
                @csrf
                <div id="methodField"></div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Departemen</label>
                        <div class="col-sm-9">
                            <select name="department_id" id="departmentId" class="chosen-select form-control" required data-placeholder="-- Pilih Departemen --">
                                <option value=""></option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Posisi</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="positionName" class="chosen-select form-control" placeholder="Contoh: Senior Software Engineer" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Deskripsi Tugas Posisi / Jabatan</label>
                        <div class="col-sm-9">
                            <textarea name="task" id="task" class="form-control" placeholder="Masukkan deskripsi tugas atau tanggung jawab posisi...">{{ old('task', $position->task ?? '') }}</textarea>
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