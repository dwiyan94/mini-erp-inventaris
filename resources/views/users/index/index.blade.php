@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Manajemen Akun User</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li class="active"><strong>User</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                <i class="fa fa-plus"></i> Tambah User
            </button>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Akun Pengguna Sistem</h5>
                </div>
                <div class="ibox-content">                   

                    <!-- Filter / Pencarian -->
                    @include('users.index.filter')

                    <!-- Tabel Data -->
                    @include('users.index.table')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
@include('users.form.form')

@endsection

@push('scripts')
    @include('users.index.js')
@endpush