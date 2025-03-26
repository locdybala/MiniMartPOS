@extends('admin.layouts.admin-layout')
@section('content')
    <div class="page-inner">
        @php
            $title = 'Nhóm khách hàng';
            $i = 0;
            $action = 'Danh sách';
        @endphp
        @include('admin.components.page-header', ['title' => $title, 'action' => $action])
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Quản lý {{$title}}</h4>
                            <button
                                class="btn btn-primary btn-round ms-auto"
                                data-bs-toggle="modal"
                                data-bs-target="#addGroupForm"
                            >
                                <i class="fa fa-plus"></i>
                                Thêm mới
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal fade" id="addGroupForm" tabindex="-1" role="dialog" aria-hidden="true">
                            <form id="groupForm">
                                @csrf
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">Thêm mới {{$title}}</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Tên nhóm</label>
                                                        <input id="nameGroup" name="nameGroup" type="text" class="form-control" placeholder="Nhập tên nhóm">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default">
                                                            <label>Trạng thái</label>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="statusGroup" name="statusGroup" checked>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" id="addGroup" class="btn btn-primary">Thêm mới</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table id="group-table" class="display table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên nhóm</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customerGroups as $group)
                                    @php $i++; @endphp
                                    <tr>
                                        <td> {{$i}}</td>
                                        <td>{{$group->name}}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" class="btn btn-link btn-primary editGroupBtn"
                                                        data-id="{{$group->id}}" data-name="{{$group->name}}"
                                                        data-bs-toggle="modal" data-bs-target="#editGroupModal">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <!-- Modal Sửa -->
                                                <div class="modal fade" id="editGroupModal" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header border-0">
                                                                <h5 class="modal-title">
                                                                    <span class="fw-mediumbold">Chỉnh sửa</span>
                                                                    <span class="fw-light"> Nhóm khách hàng </span>
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="editGroupCustomerForm">
                                                                    @csrf
                                                                    <input type="hidden" id="editGroupCustomerId">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Tên nhóm khách hàng</label>
                                                                                <input id="editNameGroupCustomer" name="name" type="text" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Trạng thái</label>
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input" type="checkbox" id="editStatusGroupCustomer">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0">
                                                                        <button type="button" id="updateGroupCustomer" class="btn btn-primary">Cập nhật</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" class="btn btn-link btn-danger deleteGroup"
                                                        data-id="{{$group->id}}">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            // Thêm nhóm khách hàng
            $("#addGroup").click(function (e) {
                e.preventDefault();
                let name = $("#nameGroup").val();
                let status = $("#statusGroup").is(":checked") ? 1 : 0;

                $.ajax({
                    url: "{{ route('customer_groups.store') }}",
                    type: "POST",
                    data: {
                        name: name,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            $("#addGroupForm").modal("hide");
                            notifySuccess(response.message);
                            setTimeout(function () { location.reload(); }, 2000);
                        }
                    },
                    error: handleAjaxError
                });
            });

            // Sửa nhóm khách hàng
            $(document).on("click", ".editGroupBtn", function () {
                let id = $(this).data("id");
                let name = $(this).data("name");
                let status = $(this).data("status");

                // Gán dữ liệu vào modal
                $("#editGroupCustomerId").val(id);
                $("#editNameGroupCustomer").val(name);
                $("#editStatusGroupCustomer").prop("checked", status == 1);

                // Hiển thị modal chỉnh sửa
                $("#editGroupModal").modal("show");
            });

            $(document).on("click", "#updateGroupCustomer", function (e) {
                e.preventDefault();

                let id = $("#editGroupCustomerId").val();
                let name = $("#editNameGroupCustomer").val();
                let status = $("#editStatusGroupCustomer").is(":checked") ? 1 : 0;

                $.ajax({
                    url: "/admin/customer_groups/" + id, // Đặt đúng URL API
                    type: "PUT", // Sử dụng PUT theo chuẩn RESTful
                    data: {
                        id: id,
                        name: name,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            $("#editGroupModal").modal("hide");
                            notifySuccess(response.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: handleAjaxError
                });
            });

            // Xóa nhóm khách hàng
            $(document).on("click", ".deleteGroup", function (e) {
                e.preventDefault();
                let groupId = $(this).data("id");

                if (confirm("Bạn có chắc muốn xóa nhóm này không?")) {
                    $.ajax({
                        url: "/admin/customer_groups/" + groupId,
                        type: "DELETE",
                        data: { _token: "{{ csrf_token() }}" },
                        success: function (response) {
                            notifySuccess(response.message);
                            setTimeout(function () { location.reload(); }, 2000);
                        },
                        error: handleAjaxError
                    });
                }
            });


            // Hàm thông báo thành công
            function notifySuccess(message) {
                debugger
                $.notify({
                    icon: "icon-bell",
                    title: 'Thông báo',
                    message: message
                }, {
                    type: 'success',
                    placement: { from: "top", align: "right" },
                    time: 1000
                });
            }

            // Hàm xử lý lỗi Ajax
            function handleAjaxError(xhr) {
                let errors = xhr.responseJSON.errors;
                $.notify({
                    icon: "icon-bell",
                    title: 'Lỗi',
                    message: errors ? errors[Object.keys(errors)[0]][0] : 'Đã có lỗi xảy ra!'
                }, {
                    type: 'danger',
                    placement: { from: "top", align: "right" },
                    time: 1000
                });
            }
        });
    </script>

@endsection
