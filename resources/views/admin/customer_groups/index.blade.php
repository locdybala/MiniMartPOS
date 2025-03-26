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
                                            <button type="button" class="btn btn-link btn-primary editGroupBtn" data-id="{{$group->id}}" data-name="{{$group->name}}" data-bs-toggle="modal" data-bs-target="#editGroupModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-link btn-danger deleteGroup" data-id="{{$group->id}}">
                                                <i class="fa fa-times"></i>
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
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $("#addGroup").click(function (e) {
                e.preventDefault(); // Ngăn chặn form submit mặc định

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
                            $.notify({
                                icon: "icon-bell",
                                title: 'Thông báo',
                                message: response.message
                            }, {
                                type: 'success',
                                placement: {
                                    from: "top",
                                    align: "right",
                                },
                                time: 1000
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        $.notify({
                            icon: "icon-bell",
                            title: 'Thông báo',
                            message: errors[Object.keys(errors)[0]][0]
                        }, {
                            type: 'warning',
                            placement: {
                                from: "top",
                                align: "right",
                            },
                            time: 1000
                        });
                    }
                });
            });
        });
        $(document).on("click", ".editCategoryBtn", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            let description = $(this).data("description");
            let status = $(this).data("status");

            // Gán giá trị vào các ô input trong modal
            $("#editgroupId").val(id);
            $("#editNameCategory").val(name);
            $("#editDescription").val(description);
            $("#editStatusCategory").prop("checked", status == 1);

            // Mở modal (trong trường hợp Bootstrap chưa tự mở)
            $("#editCategoryModal").modal("show");
        });

        $(document).on("click", "#updateCategory", function (e) {
            e.preventDefault(); // Ngăn form submit mặc định

            let id = $("#editgroupId").val();
            let name = $("#editNameCategory").val();
            let description = $("#editDescription").val();
            let status = $("#editStatusCategory").prop("checked") ? 1 : 0;

            $.ajax({
                url: "{{ route('categories.update') }}",
                type: "POST",
                data: {
                    _token: $("input[name=_token]").val(),
                    id: id,
                    name: name,
                    description: description,
                    status: status
                },
                success: function (response) {
                    if (response.status === "success") {
                        $("#editCategoryModal").modal("hide");
                        $.notify({
                            icon: "icon-bell",
                            title: 'Thông báo',
                            message: response.message
                        }, {
                            type: 'success',
                            placement: {
                                from: "top",
                                align: "right",
                            },
                            time: 1000
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        $.notify({
                            icon: "icon-bell",
                            title: 'Thông báo',
                            message: response.message
                        }, {
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "right",
                            },
                            time: 1000
                        });
                    }
                },
                error: function (error) {
                    console.log(error);
                    $.notify({
                        icon: "icon-bell",
                        title: 'Thông báo',
                        message: error.message
                    }, {
                        type: 'warning',
                        placement: {
                            from: "top",
                            align: "right",
                        },
                        time: 1000
                    });
                }
            });
        });

        //Xoá
        $(document).on("click", ".deleteGroup", function (e) {
            e.preventDefault();

            let groupId = $(this).data("id");

            // Hiển thị popup xác nhận
            if (confirm("Bạn có chắc muốn xóa nhóm này không?")) {
                $.ajax({
                    url: "/admin/customer_groups/delete/" + groupId,
                    type: "DELETE",
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    success: function (response) {
                        $.notify({
                            icon: "icon-bell",
                            title: 'Thông báo',
                            message: response.message
                        }, {
                            type: response.status === "success" ? 'success' : 'danger',
                            placement: {
                                from: "top",
                                align: "right",
                            },
                            time: 1000
                        });

                        if (response.status === "success") {
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Có lỗi xảy ra, vui lòng thử lại!");
                    }
                });
            }
        });
    </script>

@endsection
