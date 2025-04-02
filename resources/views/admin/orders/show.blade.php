@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h4 class="page-title">📦 Chi tiết đơn hàng #{{ $order->id }}</h4>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">🧑 Thông tin khách hàng</h5>
                <table class="table table-bordered">
                    <tr><th>Họ tên</th><td>{{ $order->customer_name }}</td></tr>
                    <tr><th>Số điện thoại</th><td>{{ $order->customer_phone }}</td></tr>
                    <tr><th>Email</th><td>{{ $order->customer_email }}</td></tr>
                    <tr><th>Địa chỉ</th><td>{{ $order->customer_address }}</td></tr>
                    <tr><th>Ghi chú</th><td>{{ $order->order_notes ?? 'Không có' }}</td></tr>
                </table>

                <h5 class="mb-3">🛒 Sản phẩm trong đơn</h5>
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->details as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <h5 class="mb-3">💰 Tổng thanh toán</h5>
                <table class="table table-bordered">
                    <tr><th>Tổng phụ</th><td>{{ number_format($order->subtotal, 0, ',', '.') }} VNĐ</td></tr>
                    <tr><th>Giảm giá</th><td>-{{ number_format($order->discount, 0, ',', '.') }} VNĐ</td></tr>
                    <tr><th>Phí vận chuyển</th><td>{{ number_format(20000, 0, ',', '.') }} VNĐ</td></tr>
                    <tr class="fw-bold text-danger"><th>Tổng thanh toán</th><td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td></tr>
                </table>
            </div>
        </div>
    </div>
@endsection
