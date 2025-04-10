@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h4 class="page-title">📦 Quản lý đơn hàng</h4>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    @include('admin.components.alert')
                    <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Khách hàng</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td>{{ $order->customer_email }}</td>
                            <td>{{ $order->customer_address }}</td>
                            <td class="fw-bold text-danger">
                                {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
                            </td>
                            <td>
                                    <span class="badge
                                        {{ $order->payment_method == 'cod' ? 'bg-secondary' : 'bg-primary' }}">
                                        {{ strtoupper($order->payment_method) }}
                                    </span>
                            </td>
                            <td>
                                @php
                                    $statusBadges = [
                                        'pending' => ['class' => 'bg-warning', 'label' => '🕒 Chờ xử lý'],
                                        'completed' => ['class' => 'bg-success', 'label' => '✅ Hoàn thành'],
                                        'cancelled' => ['class' => 'bg-danger', 'label' => '❌ Đã hủy'],
                                        'identify' => ['class' => 'bg-info', 'label' => '✅ Đã xác nhận'],
                                        'processing' => ['class' => 'bg-primary', 'label' => '🔄 Đang xử lý'],
                                        'shipping' => ['class' => 'bg-secondary', 'label' => '🚚 Đang vận chuyển'],
                                    ];
                                @endphp

                                @if(isset($statusBadges[$order->status]))
                                    <span class="badge {{ $statusBadges[$order->status]['class'] }}">
                                        {{ $statusBadges[$order->status]['label'] }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="form-button-action">
                                    <!-- Xem chi tiết đơn hàng -->
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-link btn-info btn-lg"><i class="fa fa-eye"></i> Xem chi tiết</a>
                                    @php
                                        $isCompleted = $order->status === 'completed';
                                        $isCancelledTooLate = $order->status === 'cancelled' && $order->created_at->addDays(3)->isPast();
                                    @endphp

                                    @if(!$isCompleted && !$isCancelledTooLate)
                                        <a href="{{ route('orders.edit-status', $order->id) }}"
                                           class="btn btn-link btn-warning btn-lg">
                                            <i class="fa fa-edit"></i> Chỉnh sửa trạng thái
                                        </a>
                                    @endif
                                    <!-- Xóa đơn hàng -->
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-danger deleteOrder" data-id="{{ $order->id }}" onclick="return confirm('Xóa đơn hàng này?')"><i class="fa fa-times"></i> Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
