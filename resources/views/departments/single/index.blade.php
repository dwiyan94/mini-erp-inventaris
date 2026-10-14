@extends('layouts.app')

@section('title', 'Detail Departemen')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Departemen: {{ $department->name }}</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="{{ route('departments.index') }}">Departemen</a></li>
            <li class="active"><strong>Detail</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <a href="{{ route('departments.index') }}" class="btn btn-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Posisi / Jabatan di bawah Departemen {{ $department->name }}</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th>Nama Posisi / Jabatan</th>
                                    <th width="20%">Tanggal Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($department->positions as $key => $position)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $position->name }}</td>
                                    <td>{{ $position->created_at->format('d-m-Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada posisi yang terdaftar di departemen ini.</td>
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