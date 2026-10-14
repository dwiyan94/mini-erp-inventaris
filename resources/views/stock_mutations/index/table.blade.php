<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>
                    <a href="{{ route('stock_mutations.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'direction' => ($sortBy == 'created_at' && $direction == 'asc') ? 'desc' : 'asc'])) }}" style="color: inherit; text-decoration: none;">
                        Tanggal
                        @if($sortBy == 'created_at')
                            <i class="fa fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort text-muted" style="font-size: 10px;"></i>
                        @endif
                    </a>
                </th>

                <th>SKU & Nama Barang</th>

                <th class="text-center" style="width: 12%;">
                    <a href="{{ route('stock_mutations.index', array_merge(request()->all(), ['sort_by' => 'type', 'direction' => ($sortBy == 'type' && $direction == 'asc') ? 'desc' : 'asc'])) }}" style="color: inherit; text-decoration: none;">
                        Tipe 
                        @if($sortBy == 'type')
                            <i class="fa fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort text-muted" style="font-size: 10px;"></i>
                        @endif
                    </a>
                </th>

                <th class="text-center" style="width: 10%;">
                    <a href="{{ route('stock_mutations.index', array_merge(request()->all(), ['sort_by' => 'quantity', 'direction' => ($sortBy == 'quantity' && $direction == 'asc') ? 'desc' : 'asc'])) }}" style="color: inherit; text-decoration: none;">
                        Jumlah 
                        @if($sortBy == 'quantity')
                            <i class="fa fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort text-muted" style="font-size: 10px;"></i>
                        @endif
                    </a>
                </th>

                <th class="text-center" style="width: 10%;">
                    <a href="{{ route('stock_mutations.index', array_merge(request()->all(), ['sort_by' => 'stock_before', 'direction' => ($sortBy == 'stock_before' && $direction == 'asc') ? 'desc' : 'asc'])) }}" style="color: inherit; text-decoration: none;">
                        Sebelum 
                        @if($sortBy == 'stock_before')
                            <i class="fa fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort text-muted" style="font-size: 10px;"></i>
                        @endif
                    </a>
                </th>

                <th class="text-center" style="width: 10%;">
                    <a href="{{ route('stock_mutations.index', array_merge(request()->all(), ['sort_by' => 'stock_after', 'direction' => ($sortBy == 'stock_after' && $direction == 'asc') ? 'desc' : 'asc'])) }}" style="color: inherit; text-decoration: none;">
                        Sesudah 
                        @if($sortBy == 'stock_after')
                            <i class="fa fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort text-muted" style="font-size: 10px;"></i>
                        @endif
                    </a>
                </th>

                <th class="text-center">Foto</th>
                <th>Memo</th>
                <th style="width: 18%;">Petugas</th>
                <th class="text-center">Act</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutations as $mutation)
            <tr>
                <td>{{ $mutation->created_at->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $mutation->product->name ?? 'Produk Dihapus' }}</strong><br>
                    <small class="text-muted">{{ $mutation->product->sku ?? '-' }}</small>
                </td>
                <td class="text-center">
                    @if($mutation->type === 'in')
                        <span class="label label-primary" style="background-color: #1ab394;">MASUK (IN)</span>
                    @else
                        <span class="label label-danger" style="background-color: #ed5565;">KELUAR (OUT)</span>
                    @endif
                </td>
                <td class="text-center"><strong>{{ $mutation->quantity }}</strong></td>
                <td class="text-center text-muted">{{ $mutation->stock_before }}</td>
                <td class="text-center"><strong class="text-navy">{{ $mutation->stock_after }}</strong></td>
                <td class="text-center">
                    @if($mutation->photo)
                        <a href="javascript:void(0);" onclick="showImageModal('{{ asset('uploads/products/mutasi/' . $mutation->photo) }}')" title="Klik untuk pratinjau">
                            <img src="{{ asset('uploads/products/mutasi/' . $mutation->photo) }}" alt="Bukti Mutasi" class="img-thumbnail" style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px;">
                        </a>
                    @else
                        <span class="text-muted" style="font-size: 11px;"><i>Tidak ada foto</i></span>
                    @endif
                </td>
                <td>{{ $mutation->notes }}</td>
                <td>{{ $mutation->user->name ?? 'System' }}</td>
                <td class="text-center">
                    <!-- Tombol Detail -->
                    <button type="button" class="btn btn-info btn-xs" onclick="showDetailMutation('{{ route('stock_mutations.show', $mutation->id) }}')" title="Lihat Detail">
                        <i class="fa fa-eye"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted">Belum ada riwayat mutasi tercatat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="text-right">
    {{ $mutations->links() }}
</div>