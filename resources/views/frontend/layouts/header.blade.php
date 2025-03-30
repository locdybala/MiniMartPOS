<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="{{asset('frontend/img/logo.png')}}" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>$150.00</span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__language">
            <img src="{{asset('frontend/img/language.png')}}" alt="">
            <div>English</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">Spanis</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div>
        <div class="header__top__right__auth">
            <a href="#"><i class="fa fa-user"></i> Login</a>
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="./index.html">Home</a></li>
            <li><a href="./shop-grid.html">Shop</a></li>
            <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li><a href="./shop-details.html">Shop Details</a></li>
                    <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                    <li><a href="./checkout.html">Check Out</a></li>
                    <li><a href="./blog-details.html">Blog Details</a></li>
                </ul>
            </li>
            <li><a href="./blog.html">Blog</a></li>
            <li><a href="./contact.html">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
            <li>Free Shipping for all Order of $99</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> taphoa@gmail.edu.com</li>
                            <li>Miễn phí ship đơn hàng từ 1.000.000 VNĐ</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        </div>
                        <div class="header__top__right__auth">
                            @if(Auth::guard('customer')->check())
                                <div class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="customerDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user"></i> {{ Auth::guard('customer')->user()->name }}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="customerDropdown">
                                        <a class="dropdown-item" href="{{ route('customer.profile') }}">Tài khoản</a>
                                        <a class="dropdown-item" href="{{ route('customer.orders') }}">Đơn hàng</a>
                                        <a class="dropdown-item" href="{{ route('customer.logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Đăng xuất
                                        </a>
                                        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('customer.login') }}"><i class="fa fa-user"></i> Đăng nhập</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="./index.html"><img src="{{asset('frontend/img/logo.png')}}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="active"><a href="{{route('frontend.home')}}">Trang chủ</a></li>
                        <li><a href="{{route('shop.index')}}">Cửa hàng</a></li>
{{--                        <li><a href="#">Pages</a>--}}
{{--                            <ul class="header__menu__dropdown">--}}
{{--                                <li><a href="./shop-details.html">Shop Details</a></li>--}}
{{--                                <li><a href="./shoping-cart.html">Shoping Cart</a></li>--}}
{{--                                <li><a href="./checkout.html">Check Out</a></li>--}}
{{--                                <li><a href="./blog-details.html">Blog Details</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                        <li><a href="{{route('posts_index')}}">Bài viết</a></li>
                        <li><a href="{{route('contact')}}">Liên hệ</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li>
                            <a href="{{ route('cart.index') }}">
                                <i class="fa fa-shopping-bag"></i>
                                <span id="cart-count">{{ Cart::getTotalQuantity() }}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="header__cart__price">Tổng tiền: <span>0</span></div>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->

<!-- Hero Section Begin -->
<section class="hero @if (!Request::is('/')) hero-normal @endif">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Tất cả danh mục</span>
                    </div>
                    <ul>
                        @foreach($categories as $category)
                            <li><a href="{{route('shop.categoryList', ['id' => $category->id])}}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                Tìm kiếm
                            </div>
                            <input type="text" placeholder="Nhập từ khoá tìm kiếm">
                            <button type="submit" class="site-btn">Tìm kiếm</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>0367.276.269</h5>
                            <span>hỗ trợ 24/7</span>
                        </div>
                    </div>
                </div>
                @if (\Illuminate\Support\Facades\Request::is('/'))
                <div class="hero__item set-bg" data-setbg="{{asset('frontend/img/hero/banner.jpg')}}">
                    <div class="hero__text">
                        <span>Tạp hoá hoá online</span>
                        <h2>Đảm bảo <br />100% chất lượng</h2>
                        <p>Miễn phí vận chuyển</p>
                        <a href="{{route('shop.index')}}" class="primary-btn">Mua ngay</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
