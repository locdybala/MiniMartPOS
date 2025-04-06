@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        @php
            $title = 'Người dùng';
            $action = 'Danh sách';
        @endphp
        @include('admin.components.page-header', ['title' => $title, 'action' => $action])

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title">Quản lý {{ $title }}</h4>
                <a href="{{ route('users.create') }}" class="btn btn-primary ms-auto">
                    <i class="fa fa-plus"></i> Thêm mới
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        @include('admin.components.alert')
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm deleteUser" data-id="{{ $user->id }}">
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
        $(document).on("click", ".deleteUser", function (e) {
            e.preventDefault();
            let userId = $(this).data("id");

            if (confirm("Bạn có chắc muốn xóa người dùng này không?")) {
                $.ajax({
                    url: "/admin/users/" + userId,
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
