<?php

namespace App\Http\Controllers\admin;


use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('admin.orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'total_price' => 0, // Tính tổng giá trị sau
                'status' => 'pending',
            ]);

            $totalPrice = 0;
            foreach ($request->products as $item) {
                $product = Product::find($item['id']);
                $subtotal = $product->price * $item['quantity'];
                $totalPrice += $subtotal;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được tạo.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'orderDetails.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được xoá.');
    }
}
