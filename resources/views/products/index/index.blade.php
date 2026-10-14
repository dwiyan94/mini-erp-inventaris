@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Manajemen Produk</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="active"><strong>Produk</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                <i class="fa fa-plus"></i> Tambah Produk
            </button>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Seluruh Produk Inventaris</h5>
                </div>
                <div class="ibox-content">
                    @include('products.index.filter')

                    @include('products.index.table')
                </div>
            </div>
        </div>
    </div>
</div>

@include('products.form.form')
@endsection

@push('scripts')
    @include('products.index.js')
@endpush