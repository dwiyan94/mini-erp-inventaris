@extends('layouts.app')

@section('title', 'Daftar Posisi')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Manajemen Posisi / Jabatan</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li class="active"><strong>Posisi atau Jabatan</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                <i class="fa fa-plus"></i> Tambah Posisi
            </button>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Seluruh Posisi Perusahaan</h5>
                </div>
                <div class="ibox-content">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Terjadi kesalahan. Pastikan semua kolom terisi dengan benar.
                        </div>
                    @endif

                    <!-- Filter / Search -->
                    @include('positions.index.filter')

                    <!-- Tabel Data -->
                    @include('positions.index.table')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
@include('positions.form.form')

@endsection

@push('scripts')
    @include('positions.index.js')
@endpush