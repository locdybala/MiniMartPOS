<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Utilities\Constant;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::getContent()->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống, vui lòng thêm sản phẩm!');
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
            'customer_id' => Auth::guard('customer')->id(), // ID khách hàng (nếu có)
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
        if ($data['payment_method'] == 'cod') {
            // Xóa giỏ hàng sau khi đặt hàng
            Cart::clear();
            Session::forget('coupon');

            // Chuyển hướng về trang cảm ơn sau khi hoàn thành đơn hàng
            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        } elseif ($data['payment_method'] == 'online_payment') {
            $data_url = $this->paymentVnpay([
                'vnp_TxnRef' => $order->id,
                'vnp_Amount' => $total,
            ]);

            return redirect($data_url);
        }

    }

    public function paymentVnpay($data)
    {
        $vnp_TmnCode = 'A8CVX1L2'; //Mã website tại VNPAY
        $vnp_HashSecret = "HJBPUUOGUYQBPUYZWBXEOTAQIBVOXUSB"; //Chuỗi bí mật
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/checkout/vnPayCheck";

        $vnp_TxnRef = date('YmdHis') . '-' . rand(1000, 9999); ; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $data['vnp_Amount'] * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $startTime = date('YmdHis');
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $startTime,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_ExpireDate" => $expire,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);
        return $vnp_Url;
    }
    public function paymentSuccess(Request $request)
    {
        try {
            $data = $request->all();
            $order = Order::find($data['vnp_TxnRef']);
            $order->update([
                'status' => 'identify',
                'payment_status' => 'paid',
            ]);
            Session::forget('coupon');
            Cart::clear();
            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!, Thanh toán online thành công');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('message', 'Có lỗi xảy ra!');
        }
    }

    public function vnPayCheck(Request $request)
    {
        $vnp_ResponseCode = $request->get('vnp_ResponseCode');
        $vnp_TxnRef = $request->get('vnp_TxnRef'); //orderId
        $vnp_Amount = $request->get('vnp_Amount'); //orderId
        if ($vnp_ResponseCode != null) {
            if ($vnp_ResponseCode == 00) {
                $order = Order::find($vnp_TxnRef);
                $order->update([
                    'status' => 'identify',
                    'payment_status' => 'paid',
                ]);
                Session::forget('coupon');
                Cart::destroy();
                return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!, Thanh toán online thành công');
            } else {
                $this->orderService->delete($vnp_TxnRef);
                return redirect('checkout/result')
                    ->with('notification', 'Thanh toán online không thành công');

            }
        }
    }
}
