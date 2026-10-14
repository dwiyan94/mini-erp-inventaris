@extends('layouts.app')

@section('title', 'Mutasi Stok Produk')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Mutasi Stok Produk</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="active"><strong>Mutasi Stok</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <button type="button" class="btn btn-primary" onclick="openMutationModal()">
                <i class="fa fa-exchange"></i> Catat Mutasi Stok
            </button>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Riwayat Keluar & Masuk Produk Inventaris</h5>
                </div>
                <div class="ibox-content">
                    @include('stock_mutations.index.filter')

                    @include('stock_mutations.index.table')
                </div>
            </div>
        </div>
    </div>
</div>

@include('stock_mutations.form.form')
@endsection

@push('scripts')
    @include('stock_mutations.index.js')
@endpush