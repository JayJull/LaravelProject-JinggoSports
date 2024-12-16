<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion fixed-sidebar" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-volleyball-ball"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">UKM OLAHRAGA</div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->routeIs('dashboard')) active @endif">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Menampilkan Navigasi Berdasarkan Role -->
    @if (auth()->check())
        @if (auth()->user()->current_role_id)
            @includeIf('layouts.' . auth()->user()->currentRole->name)
        @elseif (auth()->user()->hasRole('admin'))
            @includeIf('layouts.admin')
        @elseif (auth()->user()->hasRole('pengurus'))
            @includeIf('layouts.pengurus')
        @elseif (auth()->user()->hasRole('anggota'))
            @includeIf('layouts.anggota')
        @endif
    @endif

    <!-- Pembatas -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="border-0 rounded-circle" id="sidebarToggle"></button>
    </div>
</ul>


