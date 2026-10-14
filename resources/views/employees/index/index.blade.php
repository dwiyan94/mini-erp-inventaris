@extends('layouts.app')

@section('title', 'Daftar Pekerja')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Manajemen Pekerja</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li class="active"><strong>Pekerja</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <a href="{{ route('employees.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Pekerja
            </a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Seluruh Pekerja Perusahaan</h5>
                </div>
                <div class="ibox-content">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Terjadi kesalahan. Periksa kembali form input Anda.
                        </div>
                    @endif

                    <!-- Filter / Pencarian -->
                    @include('employees.index.filter')

                    <!-- Tabel Data -->
                    @include('employees.index.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('employees.index.js')
@endpush