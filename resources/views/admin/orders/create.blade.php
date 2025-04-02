@extends('admin.layouts.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between bg-primary p-3 text-white">
            <a href="{{ route('orders.index') }}" class="btn btn-light">⬅ Quay lại</a>
            <h5 class="mb-0">Đơn {{ session('order_id', 1) }}</h5>
            <button class="btn btn-light" onclick="newOrder()">➕</button>
        </div>

        <div class="row mt-3">
            <!-- Danh sách sản phẩm -->
            <div class="col-md-6">
                <input type="text" class="form-control mb-3" placeholder="🔍 Tìm sản phẩm vào đơn hàng"
                       id="searchProduct">
                <div class="product-list border p-3" style="max-height: 500px; overflow-y: auto;">
                    @foreach($products as $product)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" width="40"
                                     class="me-2">

                                <strong>{{ $product->name }}</strong> <br>
                                <small class="text-muted">Tồn: {{ $product->stock }}</small>
                            </div>
                            <button class="btn btn-sm btn-primary"
                                    onclick="addToOrder({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }})">
                                ➕
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Đơn hàng -->
            <div class="col-md-6">
                <!-- Ô nhập khách hàng -->
                <input type="text" id="customerSearch" class="form-control" placeholder="Thêm khách hàng vào đơn"
                       autocomplete="off">

                <!-- Danh sách khách hàng (ẩn ban đầu) -->
                <div id="customerDropdown" class="dropdown-menu w-100"
                     style="display: none; max-height: 200px; overflow-y: auto;">
                    <!-- Danh sách khách hàng sẽ được thêm vào đây -->
                </div>
                <div class="order-box border p-3" style="min-height: 300px;">
                    <p class="text-center text-muted">🛒 Đơn hàng của bạn chưa có sản phẩm nào</p>
                    <ul class="list-group" id="orderList"></ul>
                </div>
                <button class="btn btn-success w-100 mt-3" onclick="checkout()">✅ Thanh toán</button>
                <!-- Modal xác nhận thanh toán -->
                <div class="modal fade" id="confirmPaymentModal" tabindex="-1" aria-labelledby="confirmPaymentLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmPaymentLabel">Xác nhận thanh toán</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Khách hàng:</strong> <span id="customerName">Khách lẻ</span></p>
                                <p><strong>SĐT:</strong> <span id="customerPhone"></span></p>
                                <p><strong>Tổng tiền hàng:</strong> <span id="totalAmount">0 VNĐ</span></p>
                                <p><strong>Giảm giá:</strong> <input type="number" id="discount" class="form-control"
                                                                     value="0" onchange="updateFinalAmount()"> VNĐ</p>
                                <p><strong>Khách cần trả:</strong> <span id="finalAmount">0 VNĐ</span></p>

                                <div class="mb-3">
                                    <label class="form-label">Hình thức thanh toán:</label>
                                    <div>
                                        <input type="radio" id="cash" name="paymentMethod" value="cod" checked>
                                        <label for="cod">Tiền mặt</label>
                                        <input type="radio" id="transfer" name="paymentMethod" value="vnpay">
                                        <label for="vnpay">Chuyển khoản</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="customerPaid" class="form-label">Khách đưa:</label>
                                    <input type="number" id="customerPaid" class="form-control" value="0"
                                           onchange="calculateChange()">
                                </div>
                                <p><strong>Tiền thừa trả khách:</strong> <span id="changeAmount">0 VNĐ</span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-primary" onclick="confirmPayment()">Xác nhận &
                                    Thanh toán
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        let orderItems = [];

        function addToOrder(id, name, price, stock) {
            let item = orderItems.find(i => i.id === id);

            if (item) {
                if (item.quantity >= stock) {
                    alert(`⚠ Số lượng tồn kho của "${name}" không đủ!`);
                    return;
                }
                item.quantity++;
            } else {
                if (stock < 1) {
                    alert(`⚠ Sản phẩm "${name}" đã hết hàng!`);
                    return;
                }
                orderItems.push({id, name, price, quantity: 1, stock});
            }
            renderOrder();
        }

        function renderOrder() {
            let orderList = document.getElementById('orderList');
            orderList.innerHTML = "";
            let total = 0;

            orderItems.forEach((item, index) => {
                total += item.price * item.quantity;
                orderList.innerHTML += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="${item.image}" alt="" width="40" class="me-2 rounded">
                    <div>
                        <strong>${item.name}</strong> (x${item.quantity}) <br>
                        <small>${(item.price * item.quantity).toLocaleString()} VNĐ</small>
                    </div>
                </div>
                <button class="btn btn-sm btn-danger" onclick="removeItem(${index})">❌</button>
            </li>
        `;
            });

            if (orderItems.length > 0) {
                orderList.innerHTML += `<li class="list-group-item text-end"><strong>Tổng tiền: ${total.toLocaleString()} VNĐ</strong></li>`;
            } else {
                orderList.innerHTML = `<p class="text-center text-muted">🛒 Đơn hàng của bạn chưa có sản phẩm nào</p>`;
            }
        }

        function removeItem(index) {
            orderItems.splice(index, 1);
            renderOrder();
        }

        function checkout() {
            if (orderItems.length === 0) {
                alert("Giỏ hàng đang trống!");
                return;
            }

            let total = orderItems.reduce((sum, item) => sum + item.price * item.quantity, 0);

            document.getElementById("totalAmount").innerText = total.toLocaleString() + " VNĐ";
            document.getElementById("finalAmount").innerText = total.toLocaleString() + " VNĐ";
            document.getElementById("customerPaid").value = total;
            document.getElementById("changeAmount").innerText = "0 VNĐ";

            let modal = new bootstrap.Modal(document.getElementById('confirmPaymentModal'));
            modal.show();
        }

        function updateFinalAmount() {
            let total = orderItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
            let discount = parseInt(document.getElementById("discount").value) || 0;
            let finalAmount = total - discount;
            document.getElementById("finalAmount").innerText = finalAmount.toLocaleString() + " VNĐ";
            document.getElementById("customerPaid").value = finalAmount;
            calculateChange();
        }

        function calculateChange() {
            let finalAmount = parseInt(document.getElementById("finalAmount").innerText.replace(/\D/g, '')) || 0;
            let customerPaid = parseInt(document.getElementById("customerPaid").value) || 0;
            let change = customerPaid - finalAmount;
            document.getElementById("changeAmount").innerText = change.toLocaleString() + " VNĐ";
        }

        function confirmPayment() {
            debugger;
            // Lấy thông tin khách hàng từ modal
            let customerName = $('#customerName').text();
            let totalAmount = parseInt($('#totalAmount').text().replace(' VNĐ', '').replace(',', ''));
            let discount = parseInt($('#discount').val());
            let finalAmount = totalAmount - discount; // Số tiền khách hàng cần trả

            // Lấy phương thức thanh toán
            let paymentMethod = $('input[name="paymentMethod"]:checked').val();

            // Số tiền khách đưa
            let customerPaid = parseInt($('#customerPaid').val());
            let changeAmount = customerPaid - finalAmount;

            // Kiểm tra nếu tiền khách đưa không đủ
            if (customerPaid < finalAmount) {
                alert('Số tiền khách đưa không đủ!');
                return;
            }
            if (typeof orderItems === 'undefined' || orderItems.length === 0) {
                alert('Chưa có sản phẩm trong đơn hàng!');
                return;
            }


            // Gửi dữ liệu thanh toán đến server (Lưu đơn hàng vào database) bằng jQuery AJAX
            $.ajax({
                url: '{{ route("orders.checkout") }}',
                type: 'POST',
                data: {
                    customer_name: customerName,
                    total_amount: totalAmount,
                    discount: discount,
                    final_amount: finalAmount,
                    payment_method: paymentMethod,
                    customer_paid: customerPaid,
                    change_amount: changeAmount,
                    items: orderItems,
                    _token: "{{ csrf_token() }}"
                },

                success: function(response) {
                    if (response.success) {
                        alert('Đơn hàng đã được thanh toán thành công!');
                        // Làm mới lại giao diện (hoặc chuyển hướng, làm gì đó sau khi thanh toán thành công)
                        localStorage.removeItem('orderItems'); // Xóa giỏ hàng sau khi thanh toán
                        window.location.reload(); // Tải lại trang hoặc chuyển hướng
                    } else {
                        alert(data.message);
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại!');
                }
            });
        }



        function newOrder() {
            orderItems = [];
            renderOrder();
        }

        let customers = [];

        // Lấy danh sách khách hàng từ API
        function loadCustomers() {
            $.ajax({
                url: "/admin/getCustomers",
                type: "GET",
                success: function (data) {
                    customers = data;
                    renderCustomerList(customers);
                },
                error: function () {
                    alert("Không thể lấy danh sách khách hàng.");
                }
            });
        }

        // Hiển thị danh sách khách hàng
        function renderCustomerList(customers) {
            let dropdown = $("#customerDropdown");
            dropdown.empty();

            customers.forEach(function (customer) {
                let item = `<a href="#" class="dropdown-item customer-item"
                        data-id="${customer.id}"
                        data-name="${customer.name}"
                        data-phone="${customer.phone}">
                        <strong>${customer.name}</strong> <br>
                        <small>Mã: ${customer.id}</small> | <small>SDT: ${customer.phone}</small>
                    </a>`;
                dropdown.append(item);
            });

            // Xử lý khi chọn khách hàng
            $(".customer-item").on("click", function (e) {
                e.preventDefault();
                $("#customerSearch").val($(this).data("name"));
                $("#customerDropdown").hide();
            });
        }

        // Khi click vào ô nhập khách hàng
        $("#customerSearch").on("focus", function () {
            $("#customerDropdown").show();
        });

        // Ẩn danh sách nếu click ra ngoài
        $(document).on("click", function (event) {
            if (!$(event.target).closest("#customerSearch, #customerDropdown").length) {
                $("#customerDropdown").hide();
            }
        });

        // Gọi API khi trang load
        loadCustomers();
        // Khi chọn khách hàng
        $(".customer-item").on("click", function () {
            debugger
            let customerName = $(this).data("name");
            let customerPhone = $(this).data("phone");

            // Cập nhật hiển thị khách hàng trong form thanh toán
            $("#customerName").text(customerName);
            $("#customerPhone").text(customerPhone);
        });

        // Khi bấm thanh toán, nếu chưa có khách hàng thì để "Khách lẻ"
        $("#checkoutButton").on("click", function () {
            let currentCustomer = $("#customerName").text().trim();

            if (currentCustomer === "" || currentCustomer === "Khách lẻ") {
                $("#customerName").text("Khách lẻ");
                $("#customerPhone").text("");
            }
        });

    </script>
@endsection
