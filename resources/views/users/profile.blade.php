@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profil Pengguna</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li class="active"><strong>Profil Saya</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <!-- Kolom Kiri: Informasi Akun & Foto -->
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Informasi Akun</h5>
                </div>
                <div class="ibox-content text-center">
                    <div class="m-b-sm">
                        @if($user->employee && $user->employee->photo && file_exists(public_path('uploads/employees/' . $user->employee->photo)))
                            <img alt="Foto Profil" class="img-circle" src="{{ asset('uploads/employees/' . $user->employee->photo) }}" width="110" height="110" style="object-fit: cover;">
                        @else
                            <img alt="Default Profile" class="img-circle" src="{{ asset('inspinia/img/user.png') }}" width="110" height="110">
                        @endif
                    </div>
                    <h3><strong>{{ $user->name }}</strong></h3>
                    <p class="font-bold text-muted">{{ $user->email }}</p>
                    
                    <div class="text-left" style="margin-top: 20px; border-top: 1px solid #e7eaec; padding-top: 15px;">
                        <p><strong>Akun Dibuat:</strong> <span class="pull-right text-muted">{{ $user->created_at->format('d-m-Y H:i') }}</span></p>
                        <p><strong>Terakhir Diubah:</strong> <span class="pull-right text-muted">{{ $user->updated_at->format('d-m-Y H:i') }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Detail Pekerja & Role -->
        <div class="col-lg-8">
            <!-- Data Pekerja Terkait -->
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Informasi Kepegawaian</h5>
                </div>
                <div class="ibox-content">
                    @if($user->employee)
                        <table class="table table-striped">
                            <tr>
                                <td width="30%"><strong>NIK</strong></td>
                                <td>: {{ $user->employee->nik }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td class="font-bold">: {{ $user->employee->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. Handphone</strong></td>
                                <td>: {{ $user->employee->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Bergabung</strong></td>
                                <td>: {{ $user->employee->join_date ? \Carbon\Carbon::parse($user->employee->join_date)->translatedFormat('d F Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Posisi / Jabatan</strong></td>
                                <td>: {{ $user->employee->position->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Departemen</strong></td>
                                <td>: {{ $user->employee->position->department->name ?? '-' }}</td>
                            </tr>
                        </table>
                    @else
                        <div class="alert alert-warning text-center" style="margin-bottom: 0;">
                            Akun Anda belum dihubungkan dengan data kepegawaian (Employee) manapun oleh Administrator.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Role & Hak Akses -->
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Role & Hak Akses Sistem</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label><strong>Role Anda:</strong></label>
                        <div>
                            @forelse($user->getRoleNames() as $roleName)
                                <span class="label label-primary" style="font-size: 12px; margin-right: 5px; padding: 5px 10px; display: inline-block;">{{ ucfirst($roleName) }}</span>
                            @empty
                                <span class="text-muted">Tidak ada role yang terikat.</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 20px;">
                        <label><strong>Daftar Hak Akses (Permissions):</strong></label>
                        <div style="margin-top: 8px;">
                            @php
                                $allPermissions = $user->getAllPermissions();
                            @endphp

                            @forelse($allPermissions as $permission)
                                <span class="label label-info" style="margin-right: 4px; margin-bottom: 4px; display: inline-block;">{{ $permission->name }}</span>
                            @empty
                                <span class="text-muted">Tidak ada permission khusus.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection