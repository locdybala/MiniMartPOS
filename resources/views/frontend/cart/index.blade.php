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
                                                <input type="text" class="update-cart" data-id="{{ $item->id }}"
                                                       value="{{ $item->quantity }}" min="1">
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
                            <li>Subtotal <span>{){ number_format(Cart::getTotal(), 0) }} đ</span></li>
                            <li>Total <span>{{ number_format(Cart::getTotal(), 0) }} đ</span></li>
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
            $(".update-cart").on("click", function(e){
                e.preventDefault();
                var rowId = $(this).data("id"); // Đảm bảo lấy đúng ID từ nút update
                var quantity = $(this).closest("tr").find(".cart-quantity").val();

                $.ajax({
                    url: "/cart/update/" + rowId, // Đưa rowId vào URL
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        quantity: quantity
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload(); // Reload lại trang giỏ hàng
                    },
                    error: function(xhr) {
                        alert("Có lỗi xảy ra, vui lòng thử lại!");
                    }
                });
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
