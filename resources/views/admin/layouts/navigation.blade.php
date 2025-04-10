<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img
                    src="{{asset('admin/assets/img/kaiadmin/logo_light.svg')}}"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="20"
                />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <nav
        class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
    >
        <div class="container-fluid">
            <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
            >
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-search pe-1">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>
                    <input
                        type="text"
                        placeholder="Search ..."
                        class="form-control"
                    />
                </div>
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                    class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                    <a
                        class="nav-link dropdown-toggle"
                        data-bs-toggle="dropdown"
                        href="#"
                        role="button"
                        aria-expanded="false"
                        aria-haspopup="true"
                    >
                        <i class="fa fa-search"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                        <form class="navbar-left navbar-form nav-search">
                            <div class="input-group">
                                <input
                                    type="text"
                                    placeholder="Search ..."
                                    class="form-control"
                                />
                            </div>
                        </form>
                    </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="notifDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <i class="fa fa-bell"></i>
                        <span class="notification notificationCount">4</span>
                    </a>
                    <ul
                        class="dropdown-menu notif-box animated fadeIn"
                        aria-labelledby="notifDropdown"
                    >
                        <li>
                            <div class="dropdown-title">
                                Bạn có <span class="notificationCount"></span> thông báo
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center" id="low-stock-list">
                                    <!-- Nội dung thông báo sẽ được load bằng jQuery -->
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="javascript:void(0);"
                            >Xem tất cả<i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <span class="avatar-title rounded-circle border border-white bg-primary">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

            </span>
                        </div>
                        <span class="profile-username">
            <span class="op-7">Hi,</span>
            <span class="fw-bold">{{ Auth::user()->name }}</span>
        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <span class="avatar-title rounded-circle border border-white bg-primary">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </span>
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                        <a href="{{ route('profile.edit') }}" class="btn btn-xs btn-secondary btn-sm">Xem
                                            thông tin</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <p class="dropdown-item"><strong>ID:</strong> {{ Auth::user()->id }}</p>
                                <p class="dropdown-item"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                <p class="dropdown-item"><strong>Role ID:</strong> {{ Auth::user()->role_id }}</p>
                                <p class="dropdown-item"><strong>Created At:</strong> {{ Auth::user()->created_at }}</p>
                                <div class="dropdown-divider"></div>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
