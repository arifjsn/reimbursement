<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/logo.png') }}" alt="logo" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>{{ env('APP_NAME') }}</b></span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-header font-weight-bold mt-2">Main</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fa fa-tachometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header font-weight-bold mt-2">Account</li>
                <li class="nav-item">
                    <a href="{{ route('profile.index') }}" class="nav-link {{ request()->segment(1) == 'profile' ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>

                @role('Admin')
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->segment(1) == 'admin' ? 'active' : '' }}">
                        <i class="nav-icon fa fa-bar-chart"></i>
                        <p>
                            Admin
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.log.index') }}" class="nav-link {{ request()->segment(2) == 'log' ? 'active' : '' }}">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Logs</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole

                @role('User')
                <li class="nav-item">
                    <a href="{{ route('reimbursement.index') }}" class="nav-link {{ request()->segment(1) == 'reimbursement' ? 'active' : '' }}">
                        <i class="nav-icon fa fa-money"></i>
                        <p>Reimbursement</p>
                    </a>
                </li>
                @endrole

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fa fa-sign-out"></i>
                        <p>Log Out</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>