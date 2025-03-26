<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {
    public function index() {
        $products = Product::with('category', 'brand')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate multiple images
        ]);

        // Tạo sản phẩm trước
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        // Lưu nhiều ảnh nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product) {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        // Nếu có ảnh mới, xóa ảnh cũ và lưu ảnh mới
        if ($request->hasFile('images')) {
            // Xóa ảnh cũ
            $product->images()->delete();

            // Lưu ảnh mới
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product) {
        // Xóa ảnh trong thư mục storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Xóa ảnh trong database
        $product->images()->delete();

        // Xóa sản phẩm
        $product->delete();

        return response()->json(['status' => 'success', 'message' => 'Xóa sản phẩm thành công!']);
    }
}
