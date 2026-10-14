@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Manajemen Role & Hak Akses</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li class="active"><strong>Role</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                <i class="fa fa-plus"></i> Tambah Role
            </button>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Hak Akses Pengguna Sistem</h5>
                </div>
                <div class="ibox-content">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Terjadi kesalahan. Pastikan nama role unik dan valid.
                        </div>
                    @endif

                    <!-- Filter / Pencarian -->
                    @include('roles.index.filter')

                    <!-- Tabel Data -->
                    @include('roles.index.table')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
@include('roles.form.form')

@endsection

@push('scripts')
    @include('roles.index.js')
@endpush