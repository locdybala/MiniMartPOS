<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'total_price' => 0,
            'status' => 'pending'
        ]);

        $totalPrice = 0;

        foreach ($request->products as $product) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);

            $totalPrice += $product['quantity'] * $product['price'];
        }

        $order->update(['total_price' => $totalPrice]);

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được tạo.');
    }
}
