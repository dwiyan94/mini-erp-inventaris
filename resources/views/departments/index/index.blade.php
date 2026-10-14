@extends('layouts.app')

@section('title', 'Daftar Departemen')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Manajemen Departemen</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li class="active"><strong>Departemen</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                <i class="fa fa-plus-square"></i> Departemen
            </button>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Seluruh Departemen Perusahaan</h5>
                </div>
                <div class="ibox-content">
                    {{-- @if(session('success'))
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            {{ session('success') }}
                        </div>
                    @endif --}}

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Terjadi kesalahan. Pastikan nama departemen diisi dengan benar.
                        </div>
                    @endif

                    <!-- Panggil Komponen Filter -->
                    @include('departments.index.filter')

                    <!-- Panggil Komponen Tabel -->
                    @include('departments.index.table')

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Panggil Komponen Modal Form -->
@include('departments.form.form')

@endsection

@push('scripts')
    <!-- Panggil Komponen Javascript -->
    @include('departments.index.js')
@endpush