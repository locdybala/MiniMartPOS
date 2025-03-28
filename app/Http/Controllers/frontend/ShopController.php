<?php

namespace App\Http\Controllers\frontend;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ShopController extends Controller
{
    public function index()
    {
        $latestProducts = Product::orderBy('created_at', 'desc')->take(6)->get(); // 6 sản phẩm mới nhất
        $products = Product::paginate(12);
        return view('frontend.shop.index', compact('latestProducts', 'products'));
    }

    public function categoryList($id)
    {
        $category = Category::findOrFail($id);
        $latestProducts = Product::orderBy('created_at', 'desc')->take(6)->get(); // Lấy 6 sản phẩm mới nhất
        $products = Product::where('category_id', $id)->paginate(12); // Lọc theo danh mục và phân trang 12 sản phẩm mỗi trang
        return view('frontend.shop.index', compact('latestProducts', 'products', 'category'));
    }

    public function productDetails($id)
    {
        $product = Product::findOrFail($id);
        // Lấy sản phẩm liên quan cùng danh mục, loại bỏ sản phẩm hiện tại
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->take(4) // Giới hạn 4 sản phẩm
            ->get();
        return view('frontend.shop.product-details', compact('product', 'relatedProducts'));
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        // Lấy thông tin khách hàng từ session hoặc auth (tùy bạn xử lý)
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để đánh giá.');
        }

        Review::create([
            'product_id' => $productId,
            'customer_id' => $customer->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được thêm.');
    }
}
