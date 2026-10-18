<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                    
                    @if(auth()->user()->employee && auth()->user()->employee->photo && file_exists(public_path('uploads/employees/' . auth()->user()->employee->photo)))
                        <img alt="image" class="img-circle" src="{{ asset('uploads/employees/' . auth()->user()->employee->photo) }}" width="48" height="48">
                    @else
                        <img alt="Default Profile" class="img-circle" src="{{ asset('inspinia/img/user.png') }}" width="48" height="48">
                    @endif
                    
                     </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ auth()->user()->employee->name ?? auth()->user()->name }}</strong>
                     </span> <span class="text-muted text-xs block"> 
                        @if(auth()->user()->hasRole('admin'))
                            SUPERADMIN
                        @else
                            {{ strtoupper(auth()->user()->getRoleNames()->first()) }}
                        @endif

                        {{-- @php
                            $roles = auth()->user()->getRoleNames();
                        @endphp

                        @if($roles->count() > 1)
                            {{ strtoupper($roles->first()) }} <span class="badge badge-primary">+{{ $roles->count() - 1 }}</span>
                        @else
                            {{ strtoupper($roles->first() ?? 'GUEST') }}
                        @endif --}}
                        
                        <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ route('users.profile') }}">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form> 
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>

            @role(['admin', 'hr', 'owner'])
            <li class="{{ request()->is('departments') ? 'active' : '' }}">
                <a href="{{route('departments.index')}}"><i class="fa fa-building-o"></i> <span class="nav-label">Departemen</span></a>
            </li>
            @endrole

            @role(['admin', 'hr', 'owner'])
            <li class="{{ request()->is('positions') ? 'active' : '' }}">
                <a href="{{ route('positions.index') }}"><i class="fa fa-sitemap"></i> <span class="nav-label">Posisi</span></a>
            </li>
            @endrole

            @role(['admin', 'hr', 'owner'])
            <li class="{{ request()->is('employees') ? 'active' : '' }}">
                <a href="{{ route('employees.index') }}"><i class="fa fa-male"></i> <span class="nav-label">Pekerja</span></a>
            </li>
            @endrole

            @role(['admin','hr', 'owner'])
            <li class="{{ request()->routeIs('users.*', 'roles.*') ? 'active' : '' }}">
                <a href="index.html"><i class="fa fa-user-circle-o"></i> <span class="nav-label">Akses Sistem</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level {{ request()->routeIs('users.*', 'roles.*') ? 'in' : '' }}">
                    
                    <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}">User</a>
                    </li>

                    @role(['admin', 'owner'])
                    <li class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}">Role</a>
                    </li>
                    @endrole
                </ul>
            </li>
            @endrole

            @role(['admin','gudang', 'owner'])
            <li class="{{ request()->routeIs('products.*', 'stock_mutations.*') ? 'active' : '' }}">
                <a href="index.html"><i class="fa fa-book"></i> <span class="nav-label">Master Produk</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level {{ request()->routeIs() ? 'in' : '' }}">
                    
                    <li class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <a href="{{ route('products.index') }}">Data Produk</a>
                    </li>
                    <li class="{{ request()->routeIs('stock_mutations.*') ? 'active' : '' }}">
                        <a href="{{ route('stock_mutations.index') }}">Mutasi Produk</a>
                    </li>

                </ul>
            </li>
            @endrole

        </ul>

    </div>
</nav>