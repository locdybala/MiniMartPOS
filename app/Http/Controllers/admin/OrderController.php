<?php

namespace App\Http\Controllers\admin;


use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
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
            'customer_id' => 'nullable|exists:customer,id',
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
        $order = Order::with('details.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được xoá.');
    }

    public function editStatus($id)
    {
        // Lấy đơn hàng theo id
        $order = Order::findOrFail($id);

        // Trả về view với dữ liệu đơn hàng
        return view('admin.orders.edit-status', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        // Lấy đơn hàng theo id
        $order = Order::findOrFail($id);

        // Cập nhật trạng thái đơn hàng
        $order->status = $request->status;
        $order->save();

        // Chuyển hướng về danh sách đơn hàng và thông báo thành công
        return redirect()->route('orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }

    public function checkout(Request $request)
    {
        Log::info($request->all());
        // Lấy dữ liệu từ request
        $customerName = 'Khách lẻ'; // Giả sử khách mua tại cửa hàng
        $totalAmount = $request->total_amount; // Tổng tiền hàng
        $discount = $request->discount; // Giảm giá
        $finalAmount = $totalAmount - $discount; // Số tiền khách cần trả

        $paymentMethod = $request->payment_method; // Phương thức thanh toán
        $customerPaid = $request->customer_paid; // Tiền khách đưa
        $changeAmount = $customerPaid - $finalAmount; // Tiền thừa trả khách

        // Lấy thông tin các sản phẩm trong đơn hàng
        $orderItems = $request->items;

        if (empty($orderItems)) {
            return response()->json(['success' => false, 'message' => 'Chưa có sản phẩm trong đơn hàng!']);
        }

        // Tạo đơn hàng
        $order = new Order();
        $order->customer_name = $customerName;
        $order->status = "completed";
        $order->payment_method = $paymentMethod;
        $order->payment_status = $customerPaid >= $finalAmount ? 'paid' : 'unpaid';
        $order->discount_amount = $discount;
        $order->total_price = $totalAmount;
        $order->final_total = $finalAmount;
        $order->transaction_id = 'TXN' . rand(1000, 9999);
        $order->shipping_fee = 0;
        $order->note = 'Khách lẻ mua trực tiếp tại cửa hàng';
        $order->save();

        foreach ($orderItems as $item) {
            // Kiểm tra sản phẩm có tồn tại trong cơ sở dữ liệu không
            $product = Product::find($item['id']);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Sản phẩm ID ' . $item['id'] . ' không tồn tại!']);
            }

            // Lưu chi tiết đơn hàng
            OrderDetails::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đơn hàng đã được thanh toán thành công!',
            'order_id' => $order->id,
        ]);
    }

}
