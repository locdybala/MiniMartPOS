@extends('frontend.layouts.frontend_layout')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Giỏ hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('frontend.home') }}">Trang chủ</a>
                            <span>Giỏ hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                            <tr>
                                <th class="shoping__product">Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(Cart::isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">Không có sản phẩm trong giỏ hàng</td>
                                </tr>
                            @else
                                @foreach(Cart::getContent() as $item)
                                    <tr>
                                        <td class="shoping__cart__item">
                                            <img src="{{ asset('storage/'.$item->attributes->image) }}" alt="" width="50">
                                            <h5>{{ $item->name }}</h5>
                                        </td>
                                        <td class="shoping__cart__price">
                                            {{ number_format($item->price, 0) }} đ
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="number" class="cart-quantity update-cart" data-id="{{ $item->id }}" value="{{ $item->quantity }}" min="1">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__total">
                                            {{ number_format($item->price * $item->quantity, 0) }} đ
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <a href="#" data-id="{{ $item->id }}" class="remove-cart">
                                                <span class="icon_close"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{route('frontend.home')}}" class="primary-btn cart-btn">Tiếp tục mua hàng</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Cập nhật giỏ hàng</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Mã giảm giá</h5>
                            <form id="discount-form">
                                <input type="text" id="coupon_code" placeholder="Nhập mã giảm giá">
                                <button type="submit" class="site-btn">Áp dụng mã giảm giá</button>
                            </form>
                            <div id="coupon-message"></div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Tổng tiền</h5>
                        <ul>
                            <li>Tổng tiền <span class="cart-total">{{ number_format(Cart::getTotal(), 0) }} đ</span></li>
                            @php
                                if(Cart::getTotal() > 1000000) {
                                    $fee = 0;
                                } else {
                                    $fee = 20000;
                                }
                            @endphp
                            <li class="li-shipping-fee">Phí vận chuyển <span class="shipping-fee">@if($fee == 0) Miễn Phí vận chuyển @else 20,000 đ @endif</span></li>
                            @if(session('discount'))
                                <li>Giảm giá <span class="discount-amount">{{ number_format(session('discount'), 0) }} đ</span>
                                    <button id="remove-coupon" class="btn btn-danger btn-sm">Xóa</button>
                                </li>
                            @endif

                            <li>Tổng thanh toán <span class="cart-total-success">{{ number_format(Cart::getTotal() + $fee - (session('discount') ?? 0), 0) }} đ</span></li>
                        </ul>
                        @if(Auth::guard('customer')->check())
                        <a href="{{ route('checkout') }}" class="primary-btn">Thanh toán</a>
                            @else
                            <a href="{{ route('customer.login') }}" class="primary-btn">Thanh toán</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $(document).ready(function () {
                var proQty = $('.pro-qty');

                proQty.on('click', '.qtybtn', function () {
                    var $button = $(this);
                    var input = $button.siblings('input');
                    var oldValue = parseInt(input.val());

                    if ($button.hasClass('inc')) {
                        var newVal = oldValue + 1;
                    } else {
                        newVal = oldValue > 1 ? oldValue - 1 : 1; // Không cho về 0
                    }

                    input.val(newVal);

                    // Gửi Ajax để cập nhật số lượng trên server
                    updateCartQuantity(input.data('id'), newVal);
                });

                // Cập nhật khi nhập số lượng trực tiếp
                $(".cart-quantity").on("change", function () {
                    var input = $(this);
                    var newVal = parseInt(input.val());

                    if (isNaN(newVal) || newVal < 1) {
                        newVal = 1; // Không cho nhập số < 1
                    }

                    input.val(newVal);
                    updateCartQuantity(input.data('id'), newVal);
                });

                function updateCartQuantity(productId, quantity) {
                    $.ajax({
                        url: "/cart/update/" + cartId,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: productId,
                            quantity: quantity
                        },
                        success: function (response) {
                            toastr['success']("Cập nhật giỏ hàng thành công!");
                            location.reload(); // Reload để cập nhật giá trị giỏ hàng
                        },
                        error: function () {
                            toastr["error"]("Có lỗi xảy ra, vui lòng thử lại!");
                        }
                    });
                }
            });



            $(".remove-cart").click(function (e) {
                e.preventDefault();
                var productId = $(this).data("id");

                $.ajax({
                    url: "/cart/remove/" + productId,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        toastr["success"](response.success);

                        // Xoá hàng hoá khỏi bảng giỏ hàng
                        $("a[data-id='" + productId + "']").closest("tr").remove();

                        // Cập nhật tổng tiền
                        $(".cart-total").text(response.total.toLocaleString() + " đ");
                    },
                    error: function () {
                        toastr["error"]("Có lỗi xảy ra, vui lòng thử lại!");
                    }
                });
            });
        });
        $(document).ready(function () {
            $("#discount-form").submit(function (e) {
                e.preventDefault();
                var couponCode = $("#coupon_code").val();

                $.ajax({
                    url: "/cart/apply-coupon",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon_code: couponCode
                    },
                    success: function (response) {
                        toastr["success"]("Áp dụng mã giảm giá thành công!");

                        // Cập nhật giao diện
                        if ($(".discount-amount").length) {
                            $(".discount-amount").text(response.discount.toLocaleString() + " đ");
                        } else {
                            $(".li-shipping-fee").after(`<li>Giảm giá <span class="discount-amount">${response.discount.toLocaleString()} đ</span><button id="remove-coupon" class="btn btn-danger btn-sm">Xóa</button></li>`);
                        }

                        $(".cart-total-success").text(response.new_total.toLocaleString() + " đ");
                    },
                    error: function (xhr) {
                        toastr["error"](xhr.responseJSON.error);
                    }
                });
            });
        });
        $(document).ready(function () {
            $("#remove-coupon").click(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "/cart/remove-coupon",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        toastr["success"]("Đã xóa mã giảm giá!");

                        // Xóa phần hiển thị giảm giá
                        $(".discount-amount").closest("li").remove();

                        // Cập nhật lại tổng tiền
                        $(".cart-total-success").text(response.new_total.toLocaleString() + " đ");
                    },
                    error: function () {
                        toastr["error"]("Có lỗi xảy ra, vui lòng thử lại!");
                    }
                });
            });
        });

    </script>

@endsection
