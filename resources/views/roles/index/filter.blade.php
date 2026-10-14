<div class="row m-b-md">
    <div class="col-sm-12">
        <form method="GET" action="{{ route('roles.index') }}" class="form-inline pull-right">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama role..." class="form-control">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('roles.index') }}" class="btn btn-white" title="Reset">
                            <i class="fa fa-refresh"></i>
                        </a>
                    @endif
                </span>
            </div>
        </form>
    </div>
</div>