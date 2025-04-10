@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        <h4 class="page-title">📦 Quản lý tồn kho</h4>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                @include('admin.components.alert')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th class="text-start">Tên sản phẩm</th>
                            <th>Đã nhập</th>
                            <th>Đã bán</th>
                            <th>Tồn kho</th>
                            <th>Giá nhập gần nhất</th>
                            <th>Giá bán</th>
                            <th>Trạng thái</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start">
                                    <strong>{{ $product->name }}</strong>
                                </td>
                                <td>{{ $product->imported_quantity }}</td>
                                <td>{{ $product->sold_quantity }}</td>
                                <td>
                                    <span class="badge {{ $product->stock <= 10 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    @if ($product->latest_import_price)
                                        <span class="badge bg-info text-dark">
                                            {{ number_format($product->latest_import_price) }} VNĐ
                                        </span>
                                    @else
                                        <span class="text-muted fst-italic">Chưa có</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ number_format($product->price, 0) }} VNĐ
                                    </span>
                                </td>
                                <td>
                                    @if($product->stock <= 5)
                                        <span class="badge bg-danger">⚠ Sắp hết hàng</span>
                                    @else
                                        <span class="badge bg-success">✅ Còn hàng</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
