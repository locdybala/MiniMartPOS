<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
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
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item">
                    <a  href="{{route('dashboard')}}">
                        <i class="fas fa-home"></i>
                        <p>Trang chủ</p>
                    </a>
                </li>
                <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                    <h4 class="text-section">Chức năng</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fas fa-layer-group"></i>
                        <p>Sản phẩm</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('categories.index') }}">
                                    <span class="sub-item">Danh mục</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('brands.index') }}">
                                    <span class="sub-item">Thương hiệu</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('suppliers.index') }}">
                                    <span class="sub-item">Nhà cung cấp</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('products.index') }}">
                                    <span class="sub-item">Sản phẩm</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarLayouts">
                        <i class="fas fa-user"></i>
                        <p>Khách hàng</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{route('customer_groups.index')}}">
                                    <span class="sub-item">Nhóm khách hàng</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('customer.index')}}">
                                    <span class="sub-item">Khách hàng</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#forms">
                        <i class="fas fa-pen-square"></i>
                        <p>Bán lẻ online</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{route('orders.create')}}">
                                    <span class="sub-item">Bán hàng</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('orders.index')}}">
                                    <span class="sub-item">Hoá đơn</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#tables">
                        <i class="fas fa-table"></i>
                        <p>Kho hàng</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('import-orders.index') }}">
                                    <span class="sub-item">Nhập kho</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('inventory.index') }}">
                                    <span class="sub-item">Tồn kho</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a  href="{{route('posts.index')}}">
                        <i class="fas fa-book"></i>
                        <p>Quản lý bài viết</p>

                    </a>
                </li>
                <li class="nav-item">
                    <a  href="{{route('coupons.index')}}">
                        <i class="fas fa-couch"></i>
                        <p>Quản lý mã giảm giá</p>

                    </a>
                </li>
                <li class="nav-item">
                    <a  href="{{route('users.index')}}">
                        <i class="fas fa-user"></i>
                        <p>Quản lý tài khoản</p>

                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
