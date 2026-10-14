<div class="row m-b-md">
    <div class="col-sm-12">
        <div class="col-sm-6">
            <!-- Tombol Muat Data Demo -->
            <a href="{{ route('products.import-demo') }}" class="btn btn-primary btn-sm" onclick="confirmImportDemo(event, this)">
                <i class="fa fa-download"></i> Muat Data Demo
            </a>

            <!-- Tombol Reset Data -->
            <a href="{{ route('products.reset-demo') }}" class="btn btn-danger btn-sm" onclick="confirmResetDemo(event, this)">
                <i class="fa fa-refresh"></i> Reset Data
            </a>
        </div>
        <form action="{{ route('products.index') }}" method="GET" class="form-inline pull-right">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari SKU / Produk" class="form-control">
                <span class="input-group-btn">

                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>

                    @if(request('search'))
                        <a href="{{ route('products.index') }}" class="btn btn-white" title="Reset">
                            <i class="fa fa-refresh"></i>
                        </a>
                    @endif
                </span>
            </div>
        </form>
    </div>
</div>