@extends('admin.layouts.admin-layout')
@section('content')
    <div class="page-inner">
        @php
            $title = 'Nhà cung cấp';
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
                                data-bs-target="#addSupplierForm"
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
                            id="addSupplierForm"
                            tabindex="-1"
                            role="dialog"
                            aria-hidden="true"
                        >
                            <form id="supplierForm">
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
                                                            id="nameSupplier"
                                                            name="nameSupplier"
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Nhập tên {{$title}}"
                                                        />
                                                    </div>
                                                </div>
                                                <!-- Số điện thoại -->
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Số điện thoại</label>
                                                        <input id="phoneSupplier" name="phone" type="text" class="form-control" placeholder="Nhập số điện thoại">
                                                    </div>
                                                </div>

                                                <!-- Email -->
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Email</label>
                                                        <input id="emailSupplier" name="email" type="email" class="form-control" placeholder="Nhập email">
                                                    </div>
                                                </div>

                                                <!-- Địa chỉ -->
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Địa chỉ</label>
                                                        <input id="addressSupplier" name="address" type="text" class="form-control" placeholder="Nhập địa chỉ">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Mô tả</label>
                                                        <textarea class="form-control" id="description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Mã số thuế</label>
                                                        <input id="taxcodeSupplier" name="taxcode" type="text" class="form-control" placeholder="Nhập mã số thuế">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" id="addSupplier" class="btn btn-primary">Thêm mới</button>
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
                                @include('admin.components.alert')
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên {{$title}}</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Email</th>
                                    <th>Ghi chú</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên {{$title}}</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Email</th>
                                    <th>Ghi chú</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($suppliers as $supplier)
                                    @php $i++; @endphp
                                    <tr>
                                        <td> {{$i}}</td>
                                        <td>{{$supplier->name}}</td>
                                        <td>{{$supplier->phone}}</td>
                                        <td>{{$supplier->email}}</td>
                                        <td>{{$supplier->address}}</td>
                                        <td>{{$supplier->description}}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button"
                                                        class="btn btn-link btn-primary editSupplierBtn"
                                                        data-id="{{ $supplier->id }}"
                                                        data-name="{{ $supplier->name }}"
                                                        data-phone="{{ $supplier->phone }}"
                                                        data-email="{{ $supplier->email }}"
                                                        data-address="{{ $supplier->address }}"
                                                        data-description="{{ $supplier->description }}"
                                                        data-taxcode="{{ $supplier->taxcode }}"
                                                >
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <!-- Modal Sửa -->
                                                <div class="modal fade" id="editSupplierModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                <form id="editSupplierForm">
                                                                    @csrf
                                                                    <input type="hidden" id="editSupplierId">

                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Tên nhà cung cấp</label>
                                                                                <input id="editNameSupplier" name="name" type="text" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Số điện thoại</label>
                                                                                <input id="editPhoneSupplier" name="phone" type="text" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Email</label>
                                                                                <input id="editEmailSupplier" name="email" type="email" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Địa chỉ</label>
                                                                                <input id="editAddressSupplier" name="address" type="text" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Mô tả</label>
                                                                                <textarea class="form-control" id="editDescription"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Mã số thuế</label>
                                                                                <input id="editTaxcodeSupplier" name="taxcode" type="text" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer border-0">
                                                                        <button type="button" id="updateSupplier" class="btn btn-primary">Cập nhật</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" class="btn btn-link btn-danger deleteSupplier" data-id="{{ $supplier->id }}">
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
            $("#addSupplier").click(function (e) {
                e.preventDefault(); // Ngăn chặn form submit mặc định

                let name = $("#nameSupplier").val();
                let phone = $("#phoneSupplier").val();
                let email = $("#emailSupplier").val();
                let address = $("#addressSupplier").val();
                let description = $("#description").val();
                let taxcode = $("#taxcodeSupplier").val();

                $.ajax({
                    url: "{{ route('suppliers.store') }}", // Đảm bảo route đúng
                    type: "POST",
                    data: {
                        name: name,
                        phone: phone,
                        email: email,
                        address: address,
                        description: description,
                        taxcode: taxcode,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            $("#supplierForm")[0].reset(); // Xóa dữ liệu form sau khi thêm thành công
                            $("#addSupplierModal").modal("hide"); // Ẩn modal

                            $.notify({
                                icon: "icon-bell",
                                title: 'Thông báo',
                                message: response.message
                            }, {
                                type: 'success',
                                placement: { from: "top", align: "right" },
                                time: 1000
                            });

                            setTimeout(function () {
                                location.reload(); // Tải lại trang sau 2 giây
                            }, 2000);
                        }
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        let firstError = errors[Object.keys(errors)[0]][0];

                        $.notify({
                            icon: "icon-bell",
                            title: 'Lỗi',
                            message: firstError
                        }, {
                            type: 'warning',
                            placement: { from: "top", align: "right" },
                            time: 1000
                        });
                    }
                });
            });

        });
        $(document).on("click", ".editSupplierBtn", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            let phone = $(this).data("phone");
            let email = $(this).data("email");
            let address = $(this).data("address");
            let description = $(this).data("description");
            let taxcode = $(this).data("taxcode");
            let status = $(this).data("status");

            // Gán giá trị vào các ô input trong modal
            $("#editSupplierId").val(id);
            $("#editNameSupplier").val(name);
            $("#editPhoneSupplier").val(phone);
            $("#editEmailSupplier").val(email);
            $("#editAddressSupplier").val(address);
            $("#editDescription").val(description);
            $("#editTaxcodeSupplier").val(taxcode);
            $("#editStatusSupplier").prop("checked", status == 1);

            // Mở modal sửa nhà cung cấp
            $("#editSupplierModal").modal("show");
        });

        $(document).on("click", "#updateSupplier", function (e) {
            e.preventDefault(); // Ngăn chặn form submit mặc định

            let id = $("#editSupplierId").val();
            let name = $("#editNameSupplier").val();
            let phone = $("#editPhoneSupplier").val();
            let email = $("#editEmailSupplier").val();
            let address = $("#editAddressSupplier").val();
            let description = $("#editDescription").val();
            let taxcode = $("#editTaxcodeSupplier").val();
            let status = $("#editStatusSupplier").prop("checked") ? 1 : 0;

            $.ajax({
                url: "{{ route('suppliers.update') }}",
                type: "POST",
                data: {
                    _token: $("input[name=_token]").val(),
                    id: id,
                    name: name,
                    phone: phone,
                    email: email,
                    address: address,
                    description: description,
                    taxcode: taxcode,
                    status: status
                },
                success: function (response) {
                    if (response.status === "success") {
                        $("#editSupplierModal").modal("hide");
                        $.notify({
                            icon: "icon-bell",
                            title: 'Thông báo',
                            message: response.message
                        }, {
                            type: 'success',
                            placement: { from: "top", align: "right" },
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
                            placement: { from: "top", align: "right" },
                            time: 1000
                        });
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    $.notify({
                        icon: "icon-bell",
                        title: 'Thông báo',
                        message: errors ? errors[Object.keys(errors)[0]][0] : "Có lỗi xảy ra!"
                    }, {
                        type: 'warning',
                        placement: { from: "top", align: "right" },
                        time: 1000
                    });
                }
            });
        });

        //Xoá
        $(document).on("click", ".deleteSupplier", function (e) {
            e.preventDefault();

            let supplierId = $(this).data("id");

            // Hiển thị popup xác nhận
            if (confirm("Bạn có chắc muốn xóa Nhà cung cấp này không?")) {
                $.ajax({
                    url: "/admin/suppliers/delete/" + supplierId,
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
                            placement: { from: "top", align: "right" },
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
