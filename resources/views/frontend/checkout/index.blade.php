@extends('frontend.layouts.frontend_layout')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Thanh toán hoá đơn</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('frontend.home') }}">Trang chủ</a>
                            <span>Thanh toán</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Bạn có mã giảm giá? <a href="#">Nhấn vào đây</a> để nhập</h6>
                </div>
            </div>
            <div class="checkout__form">
                <h4>Thông Tin Thanh Toán</h4>
                @php $customer = \Illuminate\Support\Facades\Auth::guard('customer')->user(); @endphp
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout__input">
                                <p>Họ và Tên<span>*</span></p>
                                <input type="text" name="customer_name" value="{{ old('customer_name', $customer->name ?? '') }}" required>
                            </div>
                            <div class="checkout__input">
                                <p>Email<span>*</span></p>
                                <input type="email" name="customer_email" value="{{ old('customer_email', $customer->email ?? '') }}" required>
                            </div>
                            <div class="checkout__input">
                                <p>Số Điện Thoại<span>*</span></p>
                                <input type="text" name="customer_phone" value="{{ old('customer_phone', $customer->phone ?? '') }}" required>
                            </div>
                            <div class="checkout__input">
                                <p>Địa Chỉ<span>*</span></p>
                                <input type="text" name="customer_address" value="{{ old('customer_address', $customer->address ?? '') }}" required>
                            </div>
                            <div class="checkout__input">
                                <p>Ghi chú đơn hàng</p>
                                <textarea name="order_notes" class="form-control" rows="3">{{ old('order_notes') }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Đơn Hàng Của Bạn</h4>
                                <div class="checkout__order__products">Sản phẩm <span>Tổng</span></div>
                                <ul>
                                    @foreach($cartItems as $item)
                                        <li>{{ \Illuminate\Support\Str::limit($item->name, 20) }} x {{ $item->quantity }} <span>{{ number_format($item->price * $item->quantity, 0) }} đ</span></li>
                                    @endforeach
                                </ul>
                                @php
                                    if(Cart::getTotal() > 1000000 || Auth::guard('customer')->user()->customer_group_id == 1) {
                                        $fee = 0;
                                    } else {
                                        $fee = 20000;
                                    }
                                @endphp
                                <div class="checkout__order__subtotal">Tổng phụ <span>{{ number_format($subtotal, 0) }} đ</span></div>
                                <div class="checkout__order__discount">Giảm giá <span>-{{ number_format($discount, 0) }} đ</span></div>
                                <div class="checkout__order__shipping">Phí vận chuyển <span>{{ number_format($fee, 0) }} đ</span></div>
                                <div class="checkout__order__total">Tổng thanh toán <span>{{ number_format($total, 0) }} đ</span></div>
                                <h4>Phương thức thanh toán</h4>
                                <div class="checkout__input__radio">
                                    <label for="cod">
                                        Thanh toán khi nhận hàng (COD)
                                        <input type="radio" id="cod" name="payment_method" value="cod" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__radio">
                                    <label for="vnpay">
                                        Thanh toán online (VNPAY)
                                        <input type="radio" id="online_payment" name="payment_method" value="online_payment">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
{{--                                <div class="checkout__input__radio">--}}
{{--                                    <label for="momo">--}}
{{--                                        MOMO--}}
{{--                                        <input type="radio" id="momo" name="payment_method" value="momo">--}}
{{--                                        <span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="checkout__input__radio">--}}
{{--                                    <label for="paypal">--}}
{{--                                        PayPal--}}
{{--                                        <input type="radio" id="paypal" name="payment_method" value="paypal">--}}
{{--                                        <span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
                                <button type="submit" class="site-btn">ĐẶT HÀNG</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
