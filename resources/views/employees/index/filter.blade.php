<div class="row m-b-md">
    <div class="col-sm-12">
        <form method="GET" action="{{ route('employees.index') }}" class="form-inline pull-right">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIK, nama, atau no. HP..." class="form-control">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('employees.index') }}" class="btn btn-white" title="Reset">
                            <i class="fa fa-refresh"></i>
                        </a>
                    @endif
                </span>
            </div>
        </form>
    </div>
</div>