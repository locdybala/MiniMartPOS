@extends('admin.layouts.admin-layout')
@section('content')
    <div class="page-inner">
        @php
            $title = 'Sản phẩm';
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
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-round ms-auto"><i class="fa fa-plus"></i>
                                Thêm mới</a>

                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Modal -->

                        <div class="table-responsive">
                            <table
                                id="add-row"
                                class="display table table-striped table-hover"
                            >
                                @include('admin.components.alert')
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên {{$title}}</th>
                                    <th>Danh mục</th>
                                    <th>Thương hiệu</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>STT</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên {{$title}}</th>
                                    <th>Danh mục</th>
                                    <th>Thương hiệu</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($products as $product)
                                    @php $i++; @endphp
                                    <tr>
                                        <td> {{$i}}</td>
                                        <td>
                                            @if($product->images->isNotEmpty())
                                                <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" width="50">
                                            @else
                                                <img src="{{ asset('no-image.png') }}" width="50">
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->brand->name }}</td>
                                        <td>{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->status ? 'Hoạt động' : 'Ẩn' }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('products.edit', $product) }}" class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-danger deleteProduct" data-id="{{ $product->id }}"><i class="fa fa-times"></i></button>
                                                </form>
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
            $("#addCategory").click(function (e) {
                e.preventDefault(); // Ngăn chặn form submit mặc định

                let name = $("#nameCategory").val();
                let description = $("#description").val();
                let status = $("#statusCategory").is(":checked") ? 1 : 0;

                $.ajax({
                    url: "{{ route('categories.store') }}",
                    type: "POST",
                    data: {
                        name: name,
                        description: description,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            $("#addCategoryForm").modal("hide");
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
            $("#editCategoryId").val(id);
            $("#editNameCategory").val(name);
            $("#editDescription").val(description);
            $("#editStatusCategory").prop("checked", status == 1);

            // Mở modal (trong trường hợp Bootstrap chưa tự mở)
            $("#editCategoryModal").modal("show");
        });

        $(document).on("click", "#updateCategory", function (e) {
            e.preventDefault(); // Ngăn form submit mặc định

            let id = $("#editCategoryId").val();
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
        $(document).on("click", ".deleteProduct", function (e) {
            e.preventDefault();

            let productId = $(this).data("id");

            if (confirm("Bạn có chắc muốn xóa sản phẩm này không?")) {
                $.ajax({
                    url: "/admin/products/" + productId,  // Sửa URL
                    type: "DELETE",
                    data: {
                        _token: $("meta[name='csrf-token']").attr("content"),  // Lấy CSRF từ thẻ meta
                    },
                    success: function (response) {
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
                    },
                    error: function () {
                        alert("Có lỗi xảy ra, vui lòng thử lại!");
                    }
                });
            }
        });
    </script>

@endsection
