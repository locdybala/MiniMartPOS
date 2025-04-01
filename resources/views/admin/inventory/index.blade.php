@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        <h4 class="page-title">Quản lý tồn kho</h4>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    @include('admin.components.alert')
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng tồn kho</th>
                        <th>Giá nhập gần nhất</th>
                        <th>Giá bán</th>
                        <th>Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->latest_import_price ?? 'Chưa có' }}</td>
                            <td>{{ $product->selling_price }}</td>
                            <td>
                                @if($product->stock <= 10)
                                    <span class="badge bg-danger">Sắp hết hàng!</span>
                                @else
                                    <span class="badge bg-success">Còn hàng</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
