@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        <h4 class="page-title">Chi tiết phiếu nhập hàng</h4>

        <div class="card">
            <div class="card-body">
                <h5><strong>Nhà cung cấp:</strong> {{ $importOrder->supplier->name }}</h5>
                <p><strong>Ngày nhập:</strong> {{ \Carbon\Carbon::parse($importOrder->import_date)->format('d/m/Y') }}</p>

                <hr>
                <h5 class="mb-3">Danh sách sản phẩm:</h5>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá (VNĐ)</th>
                        <th>Thành tiền (VNĐ)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($importOrder->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->unit_price) }}</td>
                            <td>{{ number_format($detail->quantity * $detail->unit_price) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Tổng cộng</th>
                        <th>
                            {{ number_format($importOrder->details->sum(function($d) {
                                return $d->quantity * $d->unit_price;
                            })) }} VNĐ
                        </th>
                    </tr>
                    </tfoot>
                </table>

                <a href="{{ route('import-orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </div>
    </div>
@endsection
