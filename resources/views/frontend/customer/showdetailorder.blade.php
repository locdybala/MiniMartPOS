@extends('frontend.layouts.frontend_layout')

@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Chi tiết đơn hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('frontend.home') }}">Trang chủ</a>
                            <a href="{{ route('customer.orders') }}">Lịch sử đơn hàng</a>
                            <span>Chi tiết đơn #{{ $order->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shoping-cart spad">
        <div class="container">
            <h4 class="mb-4">Chi tiết đơn hàng #{{ $order->id }}</h4>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Phương thức thanh toán:</strong>
                @switch($order->payment_method)
                    @case('cod') Trả tiền mặt @break
                    @case('online_payment') Thanh toán online @break
                    @default Không rõ
                @endswitch
                - <strong>{{ $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</strong>
            </p>
            <p><strong>Ghi chú:</strong> {{ $order->note ?? '-' }}</p>
            <p><strong>Trạng thái:</strong>
                @switch($order->status)
                    @case('pending') <span class="badge badge-warning">Chờ xử lý</span> @break
                    @case('identify') <span class="badge badge-primary">Đã tiếp nhận</span> @break
                    @case('completed') <span class="badge badge-success">Hoàn thành</span> @break
                    @case('cancelled') <span class="badge badge-danger">Đã hủy</span> @break
                    @default <span class="badge badge-secondary">Không rõ</span>
                @endswitch
            </p>

            <p><strong>Thông tin người nhận hàng:</strong></p>
            <ul>
                <li><strong>Họ tên:</strong> {{ $order->customer_name }}</li>
                <li><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</li>
                <li><strong>Email:</strong> {{ $order->customer_email ?? '-' }}</li>
                <li><strong>Địa chỉ:</strong> {{ $order->customer_address }}</li>
            </ul>

            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th>Ảnh sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tạm tính</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $total = 0; @endphp
                    @foreach ($order->details as $detail)
                        @php $total += $detail->quantity * $detail->price; @endphp
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $detail->product_image) }}" alt="{{ $detail->product_name }}" width="80">
                            </td>
                            <td>{{ $detail->product_name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price, 0) }} đ</td>
                            <td>{{ number_format($detail->quantity * $detail->price, 0) }} đ</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-4">
                <p><strong>Thành tiền:</strong> {{ number_format($total ?? 0, 0) }} đ</p>
                <p><strong>Giảm giá:</strong> {{ number_format($order->discount_amount ?? 0, 0) }} đ</p>
                <p><strong>Phí ship:</strong> {{ number_format($order->shipping_fee ?? 0, 0) }} đ</p>
                <h5><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0) }} đ</h5>
            </div>

            <div class="mt-3">
                <a href="{{ route('customer.orders') }}" class="btn btn-secondary">← Quay lại danh sách</a>
            </div>
        </div>
    </section>
@endsection
