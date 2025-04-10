@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        <h4 class="page-title">{{ isset($importOrder) ? 'Chỉnh sửa' : 'Thêm' }} phiếu nhập hàng</h4>
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($importOrder) ? route('import-orders.update', $importOrder->id) : route('import-orders.store') }}" method="POST">
                    @csrf
                    @if(isset($importOrder))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nhà cung cấp</label>
                        <select name="supplier_id" class="form-control">
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ isset($importOrder) && $importOrder->supplier_id == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ngày nhập hàng</label>
                        <input type="date" name="import_date" class="form-control"
                               value="{{ isset($importOrder) ? $importOrder->import_date : old('import_date') }}" required>
                    </div>

                    <!-- Bọc danh sách sản phẩm trong card -->
                    <div class="card ms-3 mt-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="fw-bold mb-0">Danh sách sản phẩm</h5>
                        </div>
                        <div class="card-body" id="product-container">
                            @if(isset($importOrder) && $importOrder->details->count())
                                @foreach($importOrder->details as $index => $detail)
                                    <div class="row product-row g-2 border p-2 rounded mb-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Sản phẩm</label>
                                            <select name="products[{{ $index }}][product_id]" class="form-control">
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $detail->product_id == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Số lượng</label>
                                            <input type="number" name="products[{{ $index }}][quantity]" class="form-control" value="{{ $detail->quantity }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Đơn giá</label>
                                            <input type="number" name="products[{{ $index }}][unit_price]" class="form-control" value="{{ number_format($detail->unit_price, 0, '', '') }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Thành tiền</label>
                                            <input type="text" name="products[{{ $index }}][total_price]" class="form-control total-price" value="0" readonly>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-product">X</button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row product-row g-2 border p-2 rounded mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label">Sản phẩm</label>
                                        <select name="products[0][product_id]" class="form-control">
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Số lượng</label>
                                        <input type="number" name="products[0][quantity]" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Đơn giá</label>
                                        <input type="number" name="products[0][unit_price]" class="form-control unit-price" required>
                                        <small class="text-danger price-warning"></small>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Thành tiền</label>
                                        <input type="text" name="products[0][total_price]" class="form-control total-price" value="0" readonly>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove-product">X</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="text-end mt-3">
                            <h5 class="fw-bold">Tổng tiền: <span id="grand-total">0 VNĐ</span></h5>
                        </div>
                        <div class="card-footer">
                            <button type="button" id="add-product" class="btn btn-primary">Thêm sản phẩm</button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">{{ isset($importOrder) ? 'Cập nhật' : 'Lưu phiếu nhập' }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            let index = $("#product-container .product-row").length;

            // Thêm sản phẩm mới
            $("#add-product").click(function() {
                let newRow = $(".product-row:first").clone();

                newRow.find("select, input").each(function() {
                    let name = $(this).attr("name").replace(/\d+/, index);
                    $(this).attr("name", name).val('');
                });

                $("#product-container").append(newRow);
                index++;
            });

            // Xóa sản phẩm
            $(document).on("click", ".remove-product", function() {
                if ($("#product-container .product-row").length > 1) {
                    $(this).closest(".product-row").remove();
                } else {
                    alert("Cần ít nhất một sản phẩm!");
                }
            });
        });
        $(document).ready(function () {
            $(".unit-price").on("input", function () {
                let priceInput = $(this);
                let productId = priceInput.data("product-id");
                let enteredPrice = parseFloat(priceInput.val());

                // Lấy giá bán hiện tại từ biến productsData
                let sellingPrice = productsData[productId] || 0;

                // Kiểm tra nếu giá nhập lớn hơn giá bán
                if (enteredPrice >= sellingPrice) {
                    priceInput.siblings(".price-warning").text("⚠ Giá nhập cao hơn hoặc bằng giá bán!");
                } else {
                    priceInput.siblings(".price-warning").text("");
                }
            });
        });

        function updateTotals() {
            let grandTotal = 0;

            $(".product-row").each(function () {
                let quantity = parseInt($(this).find("input[name*='[quantity]']").val()) || 0;
                let unitPrice = parseFloat($(this).find("input[name*='[unit_price]']").val()) || 0;

                let total = quantity * unitPrice;
                $(this).find(".total-price").val(total.toLocaleString() + " VNĐ");

                grandTotal += total;
            });

            $("#grand-total").text(grandTotal.toLocaleString() + " VNĐ");
        }

        // Gọi lại khi có thay đổi
        $(document).on("input", "input[name*='[quantity]'], input[name*='[unit_price]']", function () {
            updateTotals();
        });

        // Gọi lại sau khi thêm dòng mới
        $("#add-product").click(function () {
            setTimeout(updateTotals, 100);
        });

        // Gọi lại ban đầu
        updateTotals();
    </script>

@endsection
