@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tạo đơn hàng mới</h2>
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="customer_id" class="form-label">Chọn khách hàng</label>
                <select name="customer_id" class="form-control" required>
                    @foreach(\App\Models\Customer::all() as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="product-list">
                <div class="product-item mb-3">
                    <label class="form-label">Sản phẩm</label>
                    <select name="products[0][product_id]" class="form-control">
                        @foreach(\App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} - {{ number_format($product->price, 0, ',', '.') }} VNĐ</option>
                        @endforeach
                    </select>
                    <input type="number" name="products[0][quantity]" class="form-control mt-2" placeholder="Số lượng" min="1" required>
                    <input type="hidden" name="products[0][price]" value="{{ $product->price }}">
                </div>
            </div>

            <button type="button" id="add-product" class="btn btn-secondary">Thêm sản phẩm</button>
            <button type="submit" class="btn btn-primary">Tạo đơn hàng</button>
        </form>
    </div>
@endsection
@section('js')
    <script>
        let productIndex = 1;
        document.getElementById('add-product').addEventListener('click', function() {
            let productList = document.getElementById('product-list');
            let newProduct = document.querySelector('.product-item').cloneNode(true);
            newProduct.querySelectorAll('select, input').forEach(input => {
                input.name = input.name.replace(/\d+/, productIndex);
            });
            productList.appendChild(newProduct);
            productIndex++;
        });
    </script>
@endsection
