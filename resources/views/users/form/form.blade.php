<div class="modal inmodal" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalTitle">Tambah User</h4>
            </div>
            <form id="userForm" method="POST" class="form-horizontal">
                @csrf
                <div id="methodField"></div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pekerja</label>
                        <div class="col-sm-9">
                            <!-- Tambahkan kelas chosen-select di sini -->
                            <select name="employee_id" id="employeeId" class="chosen-select form-control" data-placeholder="-- Pilih Pekerja --">
                                <option value=""></option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->nik }} - {{ $emp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama User</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="userName" class="form-control" placeholder="Nama lengkap user" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" id="userEmail" class="form-control" placeholder="Alamat email aktif" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="password" name="password" id="userPassword" class="form-control" placeholder="Masukkan password...">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-white" id="togglePasswordBtn" onclick="togglePasswordVisibility()" title="Lihat/Sembunyikan Password">
                                        <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </span>
                            </div>
                            <span class="help-block m-b-none" id="passwordHelp" style="color: #676a6c;">
                                Minimal 8 karakter, wajib memiliki huruf besar, huruf kecil, angka, dan simbol (contoh: <code>P@ssw0rd!</code>).
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Role Akses</label>
                        <div class="col-sm-9">
                            <select name="roles[]" id="userRole" class="chosen-select form-control" data-placeholder="-- Pilih Role (Bisa Lebih dari Satu) --" multiple required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
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