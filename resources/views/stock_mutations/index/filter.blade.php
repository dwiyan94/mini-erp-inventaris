<div class="row m-b-md">
    <div class="col-sm-12">
        <form action="{{ route('stock_mutations.index') }}" method="GET" class="form-inline pull-right">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk / catatan..." class="form-control input-sm">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Cari</button>
                </span>
            </div>
        </form>

        <!-- Form Filter Tanggal & Pencarian -->
        <form method="GET" action="{{ route('stock_mutations.index') }}" class="form-inline m-b-md" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
            
            <!-- Pertahankan parameter pencarian jika ada -->
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="form-group">
                <label class="font-normal" style="margin-right: 5px;">Dari Tanggal:</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control input-sm" style="border-radius: 4px;">
            </div>
            
            <div class="form-group">
                <label class="font-normal" style="margin-right: 5px; margin-left: 5px;">Sampai Tanggal:</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control input-sm" style="border-radius: 4px;">
            </div>

            <div class="form-group" style="margin-left: 5px;">
                <button type="submit" class="btn btn-primary btn-sm" style="background-color: #1ab394; border-color: #1ab394; border-radius: 4px;">
                    <i class="fa fa-filter"></i> Filter
                </button>
                <a href="{{ route('stock_mutations.index') }}" class="btn btn-white btn-sm" style="border-radius: 4px;">
                    <i class="fa fa-refresh"></i> Reset
                </a>
                <!-- Tombol Pintas Hari Ini -->
                <a href="{{ route('stock_mutations.index') }}?start_date={{ date('Y-m-d') }}&end_date={{ date('Y-m-d') }}" class="btn btn-info btn-sm" style="border-radius: 4px;">
                    <i class="fa fa-calendar"></i> Hari Ini
                </a>
            </div>
        </form>
    </div>
</div>