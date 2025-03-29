<?php

namespace App\Http\Controllers\frontend;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FrontendController extends Controller
{
    public function index()
    {
        $latestProducts = Product::orderBy('created_at', 'desc')->take(6)->get(); // 6 sản phẩm mới nhất
        $topRatedProducts = Product::withAvg('reviews', 'rating') // Lấy trung bình rating từ bảng reviews
        ->orderByDesc('reviews_avg_rating') // Sắp xếp theo rating trung bình
        ->take(6)
            ->get();
        $listProducts = Product::with('category')->orderBy('created_at', 'desc')->limit(8)->get();
        $brands = Brand::all();
        $latestPosts = Post::where('status', 1)->latest()->take(3)->get();
        return view('index', compact('latestProducts', 'topRatedProducts', 'listProducts', 'brands', 'latestPosts'));
    }

    public function contact()
    {
        return view('frontend.contact.index');
    }
}
