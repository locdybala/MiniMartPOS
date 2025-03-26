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
                <input type="text" class="form-control mb-3" placeholder="🔍 Tìm sản phẩm vào đơn hàng" id="searchProduct">
                <div class="product-list border p-3" style="max-height: 500px; overflow-y: auto;">
                    @foreach($products as $product)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <img src="{{ $product->image }}" alt="" width="40" class="me-2">
                                <strong>{{ $product->name }}</strong> <br>
                                <small class="text-muted">Tồn: {{ $product->stock }}</small>
                            </div>
                            <button class="btn btn-sm btn-primary" onclick="addToOrder({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})">➕</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Đơn hàng -->
            <div class="col-md-6">
                <button class="btn btn-outline-primary w-100 mb-2" onclick="addCustomer()">Thêm khách hàng vào đơn</button>
                <div class="order-box border p-3" style="min-height: 300px;">
                    <p class="text-center text-muted">🛒 Đơn hàng của bạn chưa có sản phẩm nào</p>
                    <ul class="list-group" id="orderList"></ul>
                </div>
                <button class="btn btn-success w-100 mt-3" onclick="checkout()">✅ Thanh toán</button>
            </div>
        </div>
    </div>

    <script>
        let orderItems = [];

        function addToOrder(id, name, price) {
            let item = orderItems.find(i => i.id === id);
            if (item) {
                item.quantity++;
            } else {
                orderItems.push({ id, name, price, quantity: 1 });
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
                    ${item.name} (x${item.quantity})
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
            alert("Tiến hành thanh toán!");
        }

        function newOrder() {
            orderItems = [];
            renderOrder();
        }
    </script>

@endsection
