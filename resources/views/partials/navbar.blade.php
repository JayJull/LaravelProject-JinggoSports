<nav class="mb-4 bg-white shadow navbar navbar-expand navbar-light topbar static-top">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="mr-3 btn btn-link d-md-none rounded-circle">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="my-2 mr-auto d-none d-sm-inline-block form-inline ml-md-3 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="border-0 form-control bg-light small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="ml-auto navbar-nav">
        {{-- Garis Pembatas --}}
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <!-- bagian yang dihapus -->
            {{-- <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 text-gray-600 d-none d-lg-inline small">{{ Auth::user()->name }}</span>

                @if (Auth::user()->gambar !== null)
                    <img class="img-profile rounded-circle" src="{{ asset('storage/foto/' . Auth::user()->gambar) }}">
                @else
                    <img class="img-profile rounded-circle" src="{{ asset('template/img/undraw_profile.svg') }}">
                @endif
            </a> --}}


            <!-- Dropdown - User Information -->
            {{-- <div class="shadow dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="mr-2 text-gray-400 fas fa-user fa-sm fa-fw"></i>
                    Profile
                </a> --}}

                <!-- bagian yang dihapus 2 -->
                {{-- @if (auth()->user()->roles->count() > 1)
                    @foreach (auth()->user()->roles->where('id', '!=', auth()->user()->current_role_id) as $role)
                        <a class="dropdown-item" href="{{ route('switch.role', $role->id) }}">
                            <i class="mr-2 text-gray-400 fas fa-exchange-alt fa-sm fa-fw"></i>

                            {{ __('Switch :name', ['name' => $role->name]) }}
                        </a>
                    @endforeach
                @endif --}}



                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="mr-2 text-gray-400 fas fa-sign-out-alt fa-sm fa-fw"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </div>
</div>
