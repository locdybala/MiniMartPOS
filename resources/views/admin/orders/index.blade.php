@extends('admin.layouts.admin-layout')

@section('content')
    <div class="container">
        <h2>Danh sách đơn hàng</h2>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Tạo đơn hàng</a>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
