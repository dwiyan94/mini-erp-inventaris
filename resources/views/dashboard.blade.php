@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Selamat Datang, {{ auth()->user()->name }}</h2>
        <p class="m-t-xs">
            Hak Akses Role: 
            @foreach(auth()->user()->getRoleNames() as $role)
                <span class="label label-primary" style="margin-right: 3px;">{{ strtoupper($role) }}</span>
            @endforeach
        </p>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    @role(['admin', 'gudang', 'owner'])
    <!-- BARIS KARTU METRIK UTAMA -->
    <div class="row">
        <!-- Widget Total SKU -->
        <div class="col-lg-3 col-md-6">
            <div class="ibox float-e-margins border-bottom">
                <div class="ibox-title" style="background-color: #fafafa;">
                    <span class="label label-success pull-right">SKU</span>
                    <h5>Total Jenis Barang</h5>
                </div>
                <div class="ibox-content" style="padding: 15px 20px;">
                    <div class="row align-items-center">
                        <div class="col-xs-8">
                            <h2 class="no-margins font-bold" style="font-size: 26px;">{{ number_format($totalSku, 0, ',', '.') }}</h2>
                            <small class="text-muted">Produk Unik Terdaftar</small>
                        </div>
                        <div class="col-xs-4 text-right">
                            <i class="fa fa-cubes fa-3x text-navy" style="opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Total Unit -->
        <div class="col-lg-3 col-md-6">
            <div class="ibox float-e-margins border-bottom">
                <div class="ibox-title" style="background-color: #fafafa;">
                    <span class="label label-info pull-right">Unit</span>
                    <h5>Akumulasi Stok</h5>
                </div>
                <div class="ibox-content" style="padding: 15px 20px;">
                    <div class="row align-items-center">
                        <div class="col-xs-8">
                            <h2 class="no-margins font-bold" style="font-size: 26px;">{{ number_format($totalUnits, 0, ',', '.') }}</h2>
                            <small class="text-muted">Total Unit Fisik di Gudang</small>
                        </div>
                        <div class="col-xs-4 text-right">
                            <i class="fa fa-archive fa-3x text-info" style="opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Low Stock -->
        <div class="col-lg-3 col-md-6">
            <div class="ibox float-e-margins border-bottom">
                <div class="ibox-title" style="background-color: #fafafa;">
                    <span class="label label-danger pull-right">Alert</span>
                    <h5>Stok Menipis</h5>
                </div>
                <div class="ibox-content" style="padding: 15px 20px;">
                    <div class="row align-items-center">
                        <div class="col-xs-8">
                            <h2 class="no-margins font-bold text-danger" style="font-size: 26px;">{{ $lowStockCount }}</h2>
                            <small class="text-muted">Barang dengan stok &lt; 5</small>
                        </div>
                        <div class="col-xs-4 text-right">
                            <i class="fa fa-warning fa-3x text-danger" style="opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Nilai Persediaan -->
        <div class="col-lg-3 col-md-6">
            <div class="ibox float-e-margins border-bottom">
                <div class="ibox-title" style="background-color: #fafafa;">
                    <span class="label label-primary pull-right" style="background-color: #1ab394;">IDR</span>
                    <h5>Nilai Persediaan</h5>
                </div>
                <div class="ibox-content" style="padding: 15px 20px;">
                    <div class="row align-items-center">
                        <div class="col-xs-12">
                            <h3 class="no-margins font-bold text-navy" style="font-size: 19px; margin-top: 2px; margin-bottom: 2px;">
                                Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}
                            </h3>
                            <small class="text-muted">Estimasi Valuasi Aset Barang</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BARIS TABEL DAFTAR BARANG LOW STOCK -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color: #ffffff; border-top: 2px solid #ed5565;">
                    <h5><i class="fa fa-exclamation-triangle text-danger"></i> Daftar Peringatan Stok Menipis (Stok &lt; 5)</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr style="background-color: #f9f9f9;">
                                    <th style="width: 5%;" class="text-center">No</th>
                                    <th style="width: 15%;">SKU</th>
                                    <th>Nama Produk</th>
                                    <th style="width: 15%;">Kategori</th>
                                    <th style="width: 10%;" class="text-center">Sisa Stok</th>
                                    <th style="width: 15%;" class="text-right">Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockProducts as $index => $product)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td><strong>{{ $product->sku }}</strong></td>
                                    <td>{{ $product->name }}</td>
                                    <td><span class="label label-default">{{ $product->category ?? '-' }}</span></td>
                                    <td class="text-center">
                                        <span class="label label-danger" style="font-size: 12px; padding: 3px 8px;">
                                            {{ $product->stock }} {{ $product->unit }}
                                        </span>
                                    </td>
                                    <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted" style="padding: 20px;">
                                        <i class="fa fa-check-circle text-navy" style="font-size: 20px;"></i><br>
                                        Bagus! Tidak ada produk dengan stok menipis saat ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    <!-- TAMPILAN KHUSUS HR / MANAJER -->
    @role(['hr', 'manajer'])
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-warning pull-right">HR</span>
                    <h5>Kepegawaian</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $totalEmployees }} Orang</h1>
                    <small>Total Karyawan Terdaftar</small>
                </div>
            </div>
        </div>
    </div>
    @endrole

</div>
@endsection

@push('scripts')
<script>
    @if(session('warning_low_stock'))
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 10000
            };
            toastr.warning('{{ session('warning_low_stock') }}', 'Peringatan Stok Gudang!');
        }, 1300);
    @endif
</script>
@endpush