@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Chỉnh sửa trạng thái đơn hàng</h4>
            <a href="{{ route('orders.index') }}" class="btn btn-primary">Quay lại</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="status">Trạng thái đơn hàng</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>🕒 Chờ xử lý</option>
                            <option value="identify" {{ $order->status == 'identify' ? 'selected' : '' }}>✅ Đã xác nhận</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>🔄 Đang xử lý</option>
                            <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>🚚 Đang vận chuyển</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Đã hoàn thành</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Đã hủy</option>
                        </select>

                    </div>

                    <button type="submit" class="btn btn-success">Cập nhật trạng thái</button>
                </form>
            </div>
        </div>
    </div>
@endsection
