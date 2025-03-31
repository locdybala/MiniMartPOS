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
                                        <a href="#" data-id="{{ $item->id }}" class="remove-cart"><span class="icon_close"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{route('frontend.home')}}" class="primary-btn cart-btn">Tiếp tục mua hàng</a>

                    </div>
                </div>
                <div class="col-lg-6"></div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Tổng tiền</h5>
                        <ul>
                            <li>Tổng tiền <span>{{ number_format(Cart::getTotal(), 0) }} đ</span></li>
                            <li>Tổng thanh toán <span>{{ number_format(Cart::getTotal(), 0) }} đ</span></li>
                        </ul>
                        <a href="" class="primary-btn">Thanh toán</a>
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
                proQty.prepend('<span class="dec qtybtn">-</span>');
                proQty.append('<span class="inc qtybtn">+</span>');

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
                        url: "{{ route('cart.update') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: productId,
                            quantity: quantity
                        },
                        success: function (response) {
                            alert("Cập nhật giỏ hàng thành công!");
                            location.reload(); // Reload để cập nhật giá trị giỏ hàng
                        },
                        error: function () {
                            alert("Có lỗi xảy ra, vui lòng thử lại!");
                        }
                    });
                }
            });



            $(".remove-cart").on("click", function(e){
                e.preventDefault();
                var rowId = $(this).data("id");

                $.ajax({
                    url: "/cart/remove/" + rowId,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload(); // Reload lại trang giỏ hàng sau khi xóa
                    },
                    error: function(xhr) {
                        alert("Có lỗi xảy ra, vui lòng thử lại!");
                    }
                });
            });
        });
    </script>

@endsection
