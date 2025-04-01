@extends('frontend.layouts.frontend_layout')

@section('content')
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Cảm ơn bạn đã đặt hàng!</h2>
                    <p>Đơn hàng của bạn đang được xử lý. Chúng tôi sẽ liên hệ với bạn sớm.</p>
                    <a href="{{ route('frontend.home') }}" class="primary-btn">Trở về trang chủ</a>
                </div>
            </div>
        </div>
    </section>
@endsection
