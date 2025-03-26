@extends('admin.layouts.admin-layout')
@section('content')
    <div class="page-inner">
        @php
            $title = 'Thương hiệu';
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
                                data-bs-target="#addBrandForm"
                            >
                                <i class="fa fa-plus"></i>
                                Thêm mới
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Modal -->
                        <div
                            class="modal fade"
                            id="addBrandForm"
                            tabindex="-1"
                            role="dialog"
                            aria-hidden="true"
                        >
                            <form id="brandForm">
                                @csrf
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">
                                                <span class="fw-mediumbold"> Thêm mới</span>
                                                <span class="fw-light"> {{$title}} </span>
                                            </h5>
                                            <button
                                                type="button"
                                                class="close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"
                                            >
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Tên {{$title}}</label>
                                                        <input
                                                            id="nameBrand"
                                                            name="nameBrand"
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Nhập tên {{$title}}"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Mô tả</label>
                                                        <textarea class="form-control" id="description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Trạng thái</label>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="statusBrand" name="statusBrand" checked>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" id="addBrand" class="btn btn-primary">Thêm mới</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>

                        <div class="table-responsive">
                            <table
                                id="add-row"
                                class="display table table-striped table-hover"
                            >
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên {{$title}}</th>
                                    <th>Người tạo</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên {{$title}}</th>
                                    <th>Người tạo</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($brands as $brand)
                                    @php $i++; @endphp
                                    <tr>
                                        <td> {{$i}}</td>
                                        <td>{{$brand->name}}</td>
                                        <td> {{ $brand->user ? $brand->user->name : 'Không xác định' }}</td>
                                        <td>@if($brand->status == 1) Hoạt động @else Không hoạt động @endif</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button"
                                                        class="btn btn-link btn-primary btn-lg editBrandBtn"
                                                        data-id="{{ $brand->id }}"
                                                        data-name="{{ $brand->name }}"
                                                        data-description="{{ $brand->description }}"
                                                        data-status="{{ $brand->status }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editBrandModal"
                                                >
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <!-- Modal Sửa -->
                                                <div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header border-0">
                                                                <h5 class="modal-title">
                                                                    <span class="fw-mediumbold">Chỉnh sửa</span>
                                                                    <span class="fw-light"> {{$title}} </span>
                                                                </h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="editBrandForm">
                                                                    @csrf
                                                                    <input type="hidden" id="editBrandId">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Tên {{$title}}</label>
                                                                                <input id="editNameBrand" name="name" type="text" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Mô tả</label>
                                                                                <textarea class="form-control" id="editDescription"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Trạng thái</label>
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input" type="checkbox" id="editStatusBrand">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0">
                                                                        <button type="button" id="updateBrand" class="btn btn-primary">Cập nhật</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" class="btn btn-link btn-danger deleteBrand" data-id="{{ $brand->id }}">
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
            $("#addBrand").click(function (e) {
                e.preventDefault(); // Ngăn chặn form submit mặc định

                let name = $("#nameBrand").val();
                let description = $("#description").val();
                let status = $("#statusBrand").is(":checked") ? 1 : 0;

                $.ajax({
                    url: "{{ route('brands.store') }}",
                    type: "POST",
                    data: {
                        name: name,
                        description: description,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            $("#addBrandForm").modal("hide");
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
                            }, 1000);
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
        $(document).on("click", ".editBrandBtn", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            let description = $(this).data("description");
            let status = $(this).data("status");

            // Gán giá trị vào các ô input trong modal
            $("#editBrandId").val(id);
            $("#editNameBrand").val(name);
            $("#editDescription").val(description);
            $("#editStatusBrand").prop("checked", status == 1);

            // Mở modal (trong trường hợp Bootstrap chưa tự mở)
            $("#editBrandModal").modal("show");
        });

        $(document).on("click", "#updateBrand", function (e) {
            e.preventDefault(); // Ngăn form submit mặc định

            let id = $("#editBrandId").val();
            let name = $("#editNameBrand").val();
            let description = $("#editDescription").val();
            let status = $("#editStatusBrand").prop("checked") ? 1 : 0;

            $.ajax({
                url: "{{ route('brands.update') }}",
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
                        $("#editBrandModal").modal("hide");
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
                        }, 1000);
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
        $(document).on("click", ".deleteBrand", function (e) {
            e.preventDefault();

            let brandId = $(this).data("id");

            // Hiển thị popup xác nhận
            if (confirm("Bạn có chắc muốn xóa danh mục này không?")) {
                $.ajax({
                    url: "/admin/brands/delete/" + brandId,
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
                            }, 1000);
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
