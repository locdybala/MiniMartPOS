<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use App\Models\OrderDetails;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::getContent()->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống, vui lòng thêm sản phẩm!');
        }

        // Tính tổng tiền của giỏ hàng (subtotal)
        $subtotal = Cart::getTotal();

        // Tính giảm giá (nếu có)
        $discount = 0;
        if (session()->has('coupon')) {
            $coupon = session()->get('coupon');
            if ($coupon['coupon_condition'] == 1) {
                $discount = $subtotal * $coupon['coupon_number'] / 100; // giảm theo %
            } else {
                $discount = $coupon['coupon_number']; // giảm tiền
            }
        }

        // Tính tổng cộng (subtotal - discount + shipping fee)
        $total = $subtotal - $discount + 20000; // Phí vận chuyển cố định là 20000 VND

        return view('frontend.checkout.index', [
            'cartItems' => Cart::getContent(),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
        ]);
    }

    public function process(Request $request)
    {
        // Kiểm tra nếu giỏ hàng trống
        if (Cart::getContent()->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống, vui lòng thêm sản phẩm!');
        }

        // Lấy thông tin thanh toán từ form
        $data = $request->all();

        // Tính tổng tiền của giỏ hàng
        $subtotal = Cart::getTotal();
        $discount = 0;
        if (session()->has('coupon')) {
            $coupon = session()->get('coupon');
            if ($coupon['coupon_condition'] == 1) {
                $discount = $subtotal * $coupon['coupon_number'] / 100; // giảm theo %
            } else {
                $discount = $coupon['coupon_number']; // giảm tiền
            }
        }

        // Tính tổng cộng (subtotal - discount + shipping fee)
        $total = $subtotal - $discount + 20000; // Phí vận chuyển cố định là 20000 VND

        // Lưu thông tin đơn hàng vào bảng 'orders'
        $order = Order::create([
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'customer_address' => $data['customer_address'],
            'note' => $data['order_notes'],
            'total_price' => $total,
            'status' => 'pending', // Trạng thái ban đầu là 'pending'
            'payment_method' => $data['payment_method'],
        ]);

        // Lưu thông tin chi tiết đơn hàng vào bảng 'order_details'
        foreach (Cart::getContent() as $item) {
            OrderDetails::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'product_name' => $item->name, // Thêm tên sản phẩm
                'product_image' => $item->attributes->image ?? '', // Thêm ảnh sản phẩm (nếu có)
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng
        Cart::clear();

        // Chuyển hướng về trang cảm ơn sau khi hoàn thành đơn hàng
        return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
    }

}
