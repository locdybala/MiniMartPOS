<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Routing\Controller;
use Cart;

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
    public function removeFromCart($id)
    {
        Cart::remove($id);
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
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
}
