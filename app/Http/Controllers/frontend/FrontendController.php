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
        $topRatedProducts = Product::orderBy('rating', 'desc')->take(6)->get(); // 6 sản phẩm đánh giá cao nhất
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
