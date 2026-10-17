<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">Foto</th>
                <th >SKU</th>
                <th>Produk</th>

                <th>Kategori</th>

                <th class="text-right">
                    <a href="{{ route('products.index', array_merge(request()->all(), ['sort_by' => 'price', 'direction' => ($sortBy == 'price' && $direction == 'asc') ? 'desc' : 'asc'])) }}" style="color: inherit; text-decoration: none;">
                        Harga (Rp) 
                        @if($sortBy == 'price')
                            <i class="fa fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort text-muted" style="font-size: 10px;"></i>
                        @endif
                    </a>
                </th>

                <th class="text-center">
                    <a href="{{ route('products.index', array_merge(request()->all(), ['sort_by' => 'stock', 'direction' => ($sortBy == 'stock' && $direction == 'asc') ? 'desc' : 'asc'])) }}" style="color: inherit; text-decoration: none;">
                        Stok 
                        @if($sortBy == 'stock')
                            <i class="fa fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort text-muted" style="font-size: 10px;"></i>
                        @endif
                    </a>
                </th>

                <th class="text-center" style="width: 250px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td class="text-center">
                    @if($product->photo && file_exists(public_path('uploads/products/items/' . $product->photo)))
                        <img src="{{ asset('uploads/products/items/' . $product->photo) }}" alt="Foto Produk" width="40" height="40" class="img-circle" style="object-fit: cover;">
                    @else
                        <span class="text-muted"><small>No Image</small></span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" style="font-weight: 600; color: #1ab394;">
                        <strong>{{ $product->sku }}</strong>
                    </a>
                </td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" style="color: #333; font-weight: 600;">
                        {{ $product->name }}
                    </a>
                </td>
                <td>{{ $product->category }}</td>
                <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if($product->stock < 5)
                        <span class="label label-danger">{{ $product->stock }} (Low Stock)</span>
                    @else
                        <span class="label label-primary">{{ $product->stock }} {{ $product->unit }}</span>
                    @endif
                </td>
                @canany(['edit-products', 'delete-products'])
                <td class="text-center">
                    <button type="button" class="btn btn-warning btn-xs" onclick='openEditModal(
                        @json($product->id),
                        @json($product->sku),
                        @json($product->name),
                        @json($product->category),
                        @json($product->unit),
                        @json($product->price),
                        @json($product->stock),
                        @json($product->photo)
                    )'>
                        <i class="fa fa-pencil"></i> Edit
                    </button>

                    @can('delete-products')
                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete('{{ $product->id }}')">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                    @endcan
                </td>
                @endcanany
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">Belum ada data barang.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="text-right">
    {{ $products->links() }}
</div>