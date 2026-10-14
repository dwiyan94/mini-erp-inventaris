@extends('layouts.app')

@section('title', isset($employee) ? 'Edit Pekerja' : 'Tambah Pekerja')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ isset($employee) ? 'Edit Data Pekerja' : 'Tambah Pekerja Baru' }}</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="{{ route('employees.index') }}">Pekerja</a></li>
            <li class="active"><strong>{{ isset($employee) ? 'Edit' : 'Tambah' }}</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <a href="{{ route('employees.index') }}" class="btn btn-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ isset($employee) ? 'Formulir Perubahan Data Pekerja' : 'Formulir Input Data Pekerja' }}</h5>
                </div>
                <div class="ibox-content">
                    <!-- Form Action & Method dinamis berdasarkan status Create / Edit -->
                    <form action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          class="form-horizontal">
                        @csrf
                        @if(isset($employee))
                            @method('PUT')
                        @endif

                        <div class="form-group @error('nik') has-error @enderror">
                            <label class="col-sm-2 control-label">ID Karyawan</label>
                            <div class="col-sm-4">
                                <input type="text" name="nik" value="{{ old('nik', $employee->nik ?? '') }}" class="form-control" placeholder="Contoh: EMP001" required>
                                @error('nik')
                                    <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group @error('name') has-error @enderror">
                            <label class="col-sm-2 control-label">Nama Lengkap</label>
                            <div class="col-sm-4">
                                <input type="text" name="name" value="{{ old('name', $employee->name ?? '') }}" class="form-control" placeholder="Nama lengkap pekerja" required>
                                @error('name')
                                    <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group @error('phone') has-error @enderror">
                            <label class="col-sm-2 control-label">No. Handphone</label>
                            <div class="col-sm-4">
                                <input type="text" 
                                       name="phone" 
                                       value="{{ old('phone', $employee->phone ?? '') }}" 
                                       class="form-control" 
                                       placeholder="Contoh: 081234567890" 
                                       maxlength="15" 
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);" 
                                       required>
                                <span class="help-block m-b-none">Hanya angka, maksimal 15 karakter.</span>
                                @error('phone')
                                    <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group @error('position_id') has-error @enderror">
                            <label class="col-sm-2 control-label">Posisi</label>
                            <div class="col-sm-4">
                                <select name="position_id" class="form-control" required>
                                    <option value="">-- Pilih Posisi / Jabatan --</option>
                                    @foreach($positions as $pos)
                                        <option value="{{ $pos->id }}" {{ old('position_id', $employee->position_id ?? '') == $pos->id ? 'selected' : '' }}>
                                            {{ $pos->department->name ?? '-' }} &raquo; {{ $pos->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group @error('join_date') has-error @enderror">
                            <label class="col-sm-2 control-label">Tanggal Bergabung</label>
                            <div class="col-sm-2">
                                <input type="date" name="join_date" value="{{ old('join_date', $employee->join_date ?? '') }}" class="form-control" required>
                                @error('join_date')
                                    <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @if(isset($employee) && $employee->photo)
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Foto Saat Ini</label>
                            <div class="col-sm-4" style="padding-top: 7px;">
                                @if(file_exists(public_path('uploads/employees/' . $employee->photo)))
                                    <img src="{{ asset('uploads/employees/' . $employee->photo) }}" alt="Foto" class="img-circle" width="60" height="60" style="object-fit: cover;">
                                @else
                                    <p class="text-muted">File foto tidak ditemukan.</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="form-group @error('photo') has-error @enderror">
                            <label class="col-sm-2 control-label">{{ isset($employee) ? 'Ganti Foto Baru' : 'Foto Profil' }}</label>
                            <div class="col-sm-4">
                                <input type="file" name="photo" class="form-control">
                                <span class="help-block m-b-none">Format: JPG, PNG, Maksimal 2MB. {{ isset($employee) ? 'Biarkan kosong jika tidak ingin mengubah foto.' : '' }}</span>
                                @error('photo')
                                    <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a href="{{ route('employees.index') }}" class="btn btn-white">Batal</a>
                                <button class="btn btn-primary" type="submit">{{ isset($employee) ? 'Perbarui Pekerja' : 'Simpan Pekerja' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection