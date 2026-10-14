<div class="row m-b-md">
    <div class="col-sm-12">
        <form method="GET" action="{{ route('departments.index') }}" class="form-inline pull-right">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Department" class="input-sm form-control">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-search"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('departments.index') }}" class="btn btn-sm btn-white" title="Reset Pencarian">
                            <i class="fa fa-refresh"></i> Reset
                        </a>
                    @endif
                </span>
            </div>
        </form>
    </div>
</div>
          