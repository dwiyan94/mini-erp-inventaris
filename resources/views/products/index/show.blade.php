@extends('layouts.app')

@section('title', 'Detail Produk & Riwayat Stok')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Produk: {{ $product->name }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('products.index') }}">Produk</a></li>
            <li class="active"><strong>Detail</strong></li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <a href="{{ route('products.index') }}" class="btn btn-white btn-sm">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    @if(session('success'))
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- Kolom Informasi Produk -->
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Informasi Produk</h5>
                </div>
                <div class="ibox-content text-center">
                    <div class="m-b-sm">
                        @if($product->photo && file_exists(public_path('uploads/products/items/' . $product->photo)))
                            <img alt="Foto Produk" class="img-thumbnail" src="{{ asset('uploads/products/items/' . $product->photo) }}" style="max-height: 180px; object-fit: cover;">
                        @else
                            <img alt="Default Image" class="img-thumbnail" src="{{ asset('inspinia/img/user.png') }}" style="max-height: 180px;">
                        @endif
                    </div>
                    <h3><strong>{{ $product->name }}</strong></h3>
                    <p class="text-muted"><small>SKU: {{ $product->sku }}</small></p>

                    <hr>

                    <table class="table table-stripped text-left" style="font-size: 13px;">
                        <tr>
                            <td><strong>Kategori</strong></td>
                            <td><span class="label label-primary">{{ $product->category }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Satuan Unit</strong></td>
                            <td>{{ $product->unit }}</td>
                        </tr>
                        <tr>
                            <td><strong>Harga Referensi</strong></td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Stok Saat Ini</strong></td>
                            <td>
                                <span class="badge {{ $product->stock > 0 ? 'badge-info' : 'badge-danger' }}" style="font-size: 14px;">
                                    {{ $product->stock }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat Oleh</strong></td>
                            <td>{{ $product->user->name ?? '-' }}</td>
                        </tr>
                    </table>

                    <!-- Tombol Aksi Mutasi In / Out -->
                    <div class="m-t-md">
                        <button type="button" class="btn btn-primary btn-sm btn-block" onclick="openMutationModal('in')">
                            <i class="fa fa-arrow-down"></i> + Catat Stok Masuk (IN)
                        </button>
                        <button type="button" class="btn btn-danger btn-sm btn-block" onclick="openMutationModal('out')">
                            <i class="fa fa-arrow-up"></i> - Catat Stok Keluar (OUT)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Histori Mutasi Stok -->
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Riwayat Mutasi Stok</h5>
                </div>
                <div class="ibox-content">
                    <!-- Form Filter Tanggal yang Lebih Elegan & Rapi -->
                    <form method="GET" action="{{ route('products.show', $product->id) }}" class="form-inline m-b-md" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                        
                        <div class="form-group">
                            <label class="font-normal" style="margin-right: 5px;">Dari Tanggal:</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control input-sm" style="border-radius: 4px;">
                        </div>
                        
                        <div class="form-group">
                            <label class="font-normal" style="margin-right: 5px; margin-left: 10px;">Sampai Tanggal:</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control input-sm" style="border-radius: 4px;">
                        </div>

                        <div class="form-group" style="margin-left: 5px;">
                            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #1ab394; border-color: #1ab394; border-radius: 4px;">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-white btn-sm" style="border-radius: 4px;">
                                <i class="fa fa-refresh"></i> Reset
                            </a>
                            <a href="{{ route('products.show', $product->id) }}?start_date={{ date('Y-m-d') }}&end_date={{ date('Y-m-d') }}" class="btn btn-info btn-sm" style="border-radius: 4px;">
                                <i class="fa fa-calendar"></i> Hari Ini
                            </a>
                        </div>
                    </form>

                    <div class="hr-line-dashed" style="margin: 15px 0;"></div>

                    <!-- Tabel Data Mutasi -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr style="background-color: #f9f9f9;">
                                    <th style="width: 18%;">Tanggal & Waktu</th>
                                    <th class="text-center" style="width: 12%;">Tipe</th>
                                    <th class="text-center" style="width: 10%;">Jumlah</th>
                                    <th class="text-center" style="width: 10%;">Sebelum</th>
                                    <th class="text-center" style="width: 10%;">Sesudah</th>
                                    <th>Catatan</th>
                                    <th style="width: 20%;">Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockMutations as $mutation)
                                <tr>
                                    <td>{{ $mutation->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        @if($mutation->type === 'in')
                                            <span class="label label-primary" style="background-color: #1ab394; padding: 4px 8px; font-weight: 600;">MASUK (IN)</span>
                                        @else
                                            <span class="label label-danger" style="background-color: #ed5565; padding: 4px 8px; font-weight: 600;">KELUAR (OUT)</span>
                                        @endif
                                    </td>
                                    <td class="text-center"><strong>{{ $mutation->quantity }}</strong></td>
                                    <td class="text-center text-muted">{{ $mutation->stock_before }}</td>
                                    <td class="text-center"><strong class="text-navy">{{ $mutation->stock_after }}</strong></td>
                                    <td>{{ $mutation->notes ?? '-' }}</td>
                                    <td><i class="fa fa-user text-muted"></i> {{ $mutation->user->name ?? 'System' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted" style="padding: 20px;">
                                        <i class="fa fa-info-circle"></i> Belum ada riwayat mutasi stok tercatat untuk rentang tanggal ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-lg-12 text-right">
                            {{ $stockMutations->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Mutasi Stok (In / Out) -->
<div class="modal inmodal" id="quickMutationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
                <h4 class="modal-title" id="mutationModalTitle">Catat Mutasi Stok</h4>
                <small class="text-muted">Produk: {{ $product->name }}</small>
            </div>
            <form action="{{ route('stock_mutations.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="type" id="mutationTypeInput">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jumlah (Qty)</label>
                        <div class="col-sm-9">
                            <!-- Tambahkan id="quantityInput" di sini -->
                            <input type="number" min="1" name="quantity" id="quantityInput" class="form-control" placeholder="0" required>
                            <span id="stockWarning" class="help-block m-b-none text-danger" style="display: none; font-size: 12px;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Catatan / Alasan</label>
                        <div class="col-sm-9">
                            <textarea name="notes" class="form-control" placeholder="Keterangan transaksi..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bukti Foto (Opsional)</label>
                        <div class="col-sm-9">
                            <input type="file" name="photo" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="mutationSubmitBtn">Simpan Mutasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openMutationModal(type) {
        $('#mutationTypeInput').val(type);
        
        // Ambil nilai stok saat ini dari variabel PHP product yang sedang dibuka
        let currentStock = parseInt('{{ $product->stock }}') || 0;
        let $qtyInput = $('#quantityInput');
        let $warning = $('#stockWarning');

        // Reset input nilai setiap modal dibuka
        $qtyInput.val('');
        $warning.hide();

        if(type === 'in') {
            $('#mutationModalTitle').text('Catat Stok Masuk (Stock In)');
            $('#mutationSubmitBtn').removeClass('btn-danger').addClass('btn-primary').text('Simpan Stok Masuk');
            
            // Hapus batasan max untuk stok masuk
            $qtyInput.removeAttr('max');
        } else {
            $('#mutationModalTitle').text('Catat Stok Keluar (Stock Out)');
            $('#mutationSubmitBtn').removeClass('btn-primary').addClass('btn-danger').text('Simpan Stok Keluar');
            
            // Berikan batasan max HTML5 sesuai sisa stok
            $qtyInput.attr('max', currentStock);
            $warning.text('Maksimal stok keluar adalah ' + currentStock + ' unit.');
            $warning.show();
        }

        $('#quickMutationModal').modal('show');
    }

    // Validasi real-time saat user mengetik jumlah keluar di halaman show
    $('#quantityInput').on('input', function() {
        let type = $('#mutationTypeInput').val();
        let currentStock = parseInt('{{ $product->stock }}') || 0;
        let enteredValue = parseInt($(this).val()) || 0;

        if (type === 'out' && enteredValue > currentStock) {
            $('#stockWarning').text('Peringatan: Jumlah melebihi sisa stok saat ini: ' + currentStock + ' !').show();
            $('#stockWarning').removeClass('text-muted').addClass('text-danger');
        } else if (type === 'out') {
            $('#stockWarning').text('Maksimal stok keluar adalah ' + currentStock + ' unit.').show();
            $('#stockWarning').removeClass('text-danger').addClass('text-muted');
        }
    });
</script>
@endsection