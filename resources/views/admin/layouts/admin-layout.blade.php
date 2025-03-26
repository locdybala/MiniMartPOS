<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport"
    />
    <link
        rel="icon"
        href="{{asset('admin/assets/img/kaiadmin/favicon.ico')}}"
        type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{asset('admin/assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
            google: {families: ["Public Sans:300,400,500,600,700"]},
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{asset('admin/assets/css/fonts.min.css')}}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('admin/assets/css/plugins.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('admin/assets/css/kaiadmin.min.css')}}"/>

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}"/>
</head>
<body>
<div class="wrapper">
    <!-- Sidebar -->
    @include('admin.layouts.sidebar')
    <!-- End Sidebar -->

    <div class="main-panel">
        @include('admin.layouts.navigation')

        <div class="container">
            @yield('content')
        </div>

        <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
                <nav class="pull-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="http://www.themekita.com">
                                ThemeKita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> Help </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> Licenses </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright">
                    2024, made with <i class="fa fa-heart heart text-danger"></i> by
                    <a href="http://www.themekita.com">ThemeKita</a>
                </div>
                <div>
                    Distributed by
                    <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
                </div>
            </div>
        </footer>
    </div>

    <!-- Custom template | don't include it in your project! -->
    <div class="custom-template">
        <div class="title">Settings</div>
        <div class="custom-content">
            <div class="switcher">
                <div class="switch-block">
                    <h4>Logo Header</h4>
                    <div class="btnSwitch">
                        <button
                            type="button"
                            class="selected changeLogoHeaderColor"
                            data-color="dark"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="blue"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="purple"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="light-blue"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="green"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="orange"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="red"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="white"
                        ></button>
                        <br/>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="dark2"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="blue2"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="purple2"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="light-blue2"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="green2"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="orange2"
                        ></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="red2"
                        ></button>
                    </div>
                </div>
                <div class="switch-block">
                    <h4>Navbar Header</h4>
                    <div class="btnSwitch">
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="dark"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="blue"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="purple"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="light-blue"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="green"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="orange"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="red"
                        ></button>
                        <button
                            type="button"
                            class="selected changeTopBarColor"
                            data-color="white"
                        ></button>
                        <br/>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="dark2"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="blue2"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="purple2"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="light-blue2"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="green2"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="orange2"
                        ></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="red2"
                        ></button>
                    </div>
                </div>
                <div class="switch-block">
                    <h4>Sidebar</h4>
                    <div class="btnSwitch">
                        <button
                            type="button"
                            class="changeSideBarColor"
                            data-color="white"
                        ></button>
                        <button
                            type="button"
                            class="selected changeSideBarColor"
                            data-color="dark"
                        ></button>
                        <button
                            type="button"
                            class="changeSideBarColor"
                            data-color="dark2"
                        ></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-toggle">
            <i class="icon-settings"></i>
        </div>
    </div>
    <!-- End Custom template -->
</div>
<!--   Core JS Files   -->
<script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('admin/assets/js/core/popper.min.js')}}"></script>
<script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>

<!-- jQuery Scrollbar -->
<script src="{{asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

<!-- Chart JS -->
<script src="{{asset('admin/assets/js/plugin/chart.js/chart.min.js')}}"></script>

<!-- jQuery Sparkline -->
<script src="{{asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

<!-- Chart Circle -->
<script src="{{asset('admin/assets/js/plugin/chart-circle/circles.min.js')}}"></script>

<!-- Datatables -->
<script src="{{asset('admin/assets/js/plugin/datatables/datatables.min.js')}}"></script>

<!-- Bootstrap Notify -->
<script src="{{asset('admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

<!-- jQuery Vector Maps -->
<script src="{{asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
<script src="{{asset('admin/assets/js/plugin/jsvectormap/world.js')}}"></script>

<!-- Sweet Alert -->
<script src="{{asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

<!-- Kaiadmin JS -->
<script src="{{asset('admin/assets/js/kaiadmin.min.js')}}"></script>


<script>
    function loadLowStockNotifications() {
        $.get("{{ url('/admin/low-stock-notifications') }}", function (data) {
            let notifList = $("#low-stock-list");
            notifList.empty(); // Xóa nội dung cũ

            if (data.products.length > 0) {
                data.products.forEach(product => {
                    notifList.append(`
                        <a href="#">
                            <div class="notif-icon notif-warning">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div class="notif-content">
                                <span class="block">${product.name} - Còn ${product.stock} sp</span>
                                <span class="time">Cảnh báo tồn kho</span>
                            </div>
                        </a>
                    `);
                });

                $(".notification").text(data.products.length).show(); // Hiển thị số lượng thông báo
            } else {
                notifList.append('<p class="text-center text-muted">Không có sản phẩm sắp hết hàng.</p>');
                $(".notification").hide(); // Ẩn số lượng thông báo
            }
        });
    }

    $(document).ready(function () {
        loadLowStockNotifications(); // Load khi trang mở
        setInterval(loadLowStockNotifications, 30000); // Cập nhật mỗi 30 giây
    });
</script>
@yield('js')
</body>
</html>
