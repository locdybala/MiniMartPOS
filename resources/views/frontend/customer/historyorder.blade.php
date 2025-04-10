@extends('frontend.layouts.frontend_layout')

@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Lịch sử đơn hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('frontend.home') }}">Trang chủ</a>
                            <span>Lịch sử đơn hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shoping-cart spad">
        <div class="container">
            <h4 class="mb-4">Danh sách đơn hàng</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Giảm giá</th>
                        <th>Phí ship</th>
                        <th>Thanh toán</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($order->total_price, 0) }} đ</td>
                            <td>{{ number_format($order->discount_amount ?? 0, 0) }} đ</td>
                            <td>{{ number_format($order->shipping_fee ?? 0, 0) }} đ</td>
                            <td>
                                @switch($order->payment_method)
                                    @case('cod') Trả tiền mặt @break
                                    @case('online_payment') Thanh toán online @break
                                    @default <span class="badge badge-secondary">Không rõ</span>
                                @endswitch
                                <br>
                                <small>{{ $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</small>
                            </td>
                            <td>{{ $order->note ?? '-' }}</td>
                            <td>
                                @switch($order->status)
                                    @case('pending') <span class="badge badge-warning">Chờ xử lý</span> @break
                                    @case('processing') <span class="badge badge-primary">Đã tiếp nhận</span> @break
                                    @case('processing') <span class="badge badge-primary">Đang xử lý</span> @break
                                    @case('completed') <span class="badge badge-success">Hoàn thành</span> @break
                                    @case('cancelled') <span class="badge badge-danger">Đã hủy</span> @break
                                    @default <span class="badge badge-secondary">Không rõ</span>
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('frontend.orders.show', $order->id) }}" class="btn btn-sm btn-info">Chi tiết</a>
                                @if(in_array($order->status, ['pending', 'processing']) && $order->payment_status != 'paid')
                                    <button
                                        class="btn btn-danger btn-sm mt-2 cancel-order-btn"
                                        data-id="{{ $order->id }}"
                                    >
                                        Hủy đơn hàng
                                    </button>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Bạn chưa có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('.cancel-order-btn').click(function (e) {
                debugger
                e.preventDefault();
                let orderId = $(this).data('id');

                if (confirm('Bạn có chắc muốn hủy đơn hàng này không?')) {
                    $.ajax({
                        url: '/cancel/' + orderId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            alert('Đơn hàng đã được hủy thành công.');
                            location.reload();
                        },
                        error: function (xhr) {
                            alert('Hủy đơn hàng thất bại. Vui lòng thử lại!' + xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
@endsection
