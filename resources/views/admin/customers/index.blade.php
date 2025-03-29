@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        @php
            $title = 'Khách hàng';
            $action = 'Danh sách';
        @endphp
        @include('admin.components.page-header', ['title' => $title, 'action' => $action])

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title">Quản lý {{ $title }}</h4>
                <a href="{{ route('customer.create') }}" class="btn btn-primary ms-auto">
                    <i class="fa fa-plus"></i> Thêm mới
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>
                                    <a href="{{ route('customer.edit', $customer) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm deleteCustomer" data-id="{{ $customer->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
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

@section('js')
    <script>
        $(document).on("click", ".deleteCustomer", function (e) {
            e.preventDefault();
            let customerId = $(this).data("id");

            if (confirm("Bạn có chắc muốn xóa khách hàng này không?")) {
                $.ajax({
                    url: "/admin/customers/" + customerId,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function () {
                        alert("Lỗi! Không thể xóa.");
                    }
                });
            }
        });
    </script>
@endsection
