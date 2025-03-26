@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Quản lý đơn hàng</h4>
            <a href="{{ route('orders.create') }}" class="btn btn-primary">Thêm đơn hàng</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer->name ?? 'Khách lẻ' }}</td>
                            <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">Chi tiết</a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa đơn hàng này?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
