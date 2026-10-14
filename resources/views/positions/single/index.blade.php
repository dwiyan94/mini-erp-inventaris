@extends('layouts.app')

@section('title', 'Detail Posisi')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Posisi: {{ $position->name }}</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="{{ route('positions.index') }}">Posisi</a></li>
            <li class="active"><strong>Detail</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <a href="{{ route('positions.index') }}" class="btn btn-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Informasi Departemen: <strong>{{ $position->department->name ?? '-' }}</strong></h5>
                </div>
                <div class="ibox-content">
                    <h4>Daftar Pekerja dengan Posisi {{ $position->name }}</h4>
                    <div class="table-responsive" style="margin-top: 15px;">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th>NIK</th>
                                    <th>Nama Pekerja</th>
                                    <th>Tanggal Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($position->employees as $key => $employee)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $employee->nik }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->join_date }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada pekerja yang terdaftar pada posisi ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection