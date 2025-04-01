<?php

namespace App\Http\Controllers\frontend;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Routing\Controller;
use Cart;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        // Lấy ảnh đầu tiên từ quan hệ images(), nếu không có thì dùng ảnh mặc định
        $imagePath = $product->images->first()
            ? $product->images->first()->image_path
            : 'default.jpg';

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $cartItem = Cart::get($product->id);

        if ($cartItem) {
            // Nếu sản phẩm đã tồn tại, cập nhật số lượng
            Cart::update($product->id, [
                'quantity' => $quantity, // Cộng thêm số lượng mới
            ]);
        } else {
            // Nếu sản phẩm chưa có, thêm mới vào giỏ hàng
            Cart::add([
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $quantity,
                'attributes' => [
                    'image' => $imagePath,
                ],
            ]);
        }

        return response()->json([
            'message'          => 'Thêm vào giỏ hàng thành công!',
            'cartTotalQuantity' => Cart::getTotalQuantity(), // Tổng số lượng trong giỏ hàng
            'cart'             => Cart::getContent()
        ]);
    }

    // Hiển thị giỏ hàng
    public function viewCart()
    {
        $cartItems = Cart::getContent();
        return view('frontend.cart.index', compact('cartItems'));
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        Cart::remove($id);

        // Tính tổng tiền mới
        $total = Cart::getTotal();

        return response()->json([
            'success' => 'Sản phẩm đã được xoá!',
            'total' => $total
        ]);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng (nếu cần)
    public function updateCart(Request $request, $id)
    {
        $quantity = (int) $request->quantity;

        // Đảm bảo số lượng tối thiểu là 1
        if ($quantity < 1) {
            return response()->json(['error' => 'Số lượng sản phẩm không hợp lệ!'], 400);
        }

        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $quantity
            ]
        ]);

        return response()->json(['message' => 'Cập nhật giỏ hàng thành công!', 'cart' => Cart::getContent()]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:255',
        ]);

        $couponCode = $request->input('coupon_code');
        $coupon = Coupon::where('coupon_code', $couponCode)
            ->whereDate('coupon_date_start', '<=', Carbon::now()->toDateString())
            ->whereDate('coupon_date_end', '>=', Carbon::now()->toDateString())
            ->first();

        if (!$coupon) {
            return response()->json(['error' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn'], 400);
        }

        $discount = 0;
        if ($coupon->coupon_condition == 1) { // Giảm theo %
            $discount = ($coupon->coupon_number / 100) * Cart::getTotal();
        } elseif ($coupon->coupon_condition == 2) { // Giảm theo số tiền
            $discount = $coupon->coupon_number;
        }

        // Lưu số tiền giảm vào session
        session(['discount' => $discount]);

        // Tính toán lại tổng tiền
        $newTotal = Cart::getTotal() + 20000 - $discount;

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'new_total' => $newTotal,
            'coupon_code' => $coupon->coupon_code
        ]);
    }

    public function removeCoupon()
    {
        session()->forget('discount'); // Xóa mã giảm giá khỏi session
        return response()->json([
            'success' => true,
            'new_total' => Cart::getTotal() + 20000 // Cập nhật lại tổng thanh toán
        ]);
    }
}
