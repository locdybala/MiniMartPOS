@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        @php
            $title = 'Phiếu nhập hàng';
            $action = 'Danh sách';
        @endphp
        @include('admin.components.page-header', ['title' => $title, 'action' => $action])

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Quản lý {{$title}}</h4>
                            <a href="{{ route('import-orders.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Thêm mới
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                id="add-row"
                                class="display table table-striped table-hover"
                            >
                                <thead>
                                <tr>
                                    <th>Mã phiếu</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Ngày nhập</th>
                                    <th>Tổng tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Mã phiếu</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Ngày nhập</th>
                                    <th>Tổng tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($importOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->supplier->name }}</td>
                                        <td>{{ $order->import_date }}</td>
                                        <td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                                        <td>
                                            <a href="{{ route('import-orders.show', $order->id) }}" class="btn btn-info btn-sm">Xem</a>
                                            <a href="{{ route('import-orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                            <form action="{{ route('import-orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
