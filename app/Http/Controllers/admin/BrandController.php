<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('user')->orderBy('id', 'desc')->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands',
            'description' => 'nullable|string',
            'status' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands', 'public'); // Lưu vào thư mục storage/app/public/brands
        }

        $brand = Brand::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0,
            'image' => $imagePath,
            'created_by' => auth()->id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Thương hiệu đã được thêm!', 'brand' => $brand]);
    }

    public function update(Request $request)
    {
        $brand = Brand::find($request->id);
        if (!$brand) {
            return response()->json(['status' => 'error', 'message' => 'Thương hiệu không tồn tại!']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image); // Xóa ảnh cũ nếu có
            }
            $brand->image = $request->file('image')->store('brands', 'public');
        }

        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->status = $request->status ? 1 : 0;
        $brand->save();

        return response()->json(['status' => 'success', 'message' => 'Cập nhật thương hiệu thành công!']);
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json(['status' => 'error', 'message' => 'Thương hiệu không tồn tại!']);
        }

        $brand->delete();
        return response()->json(['status' => 'success', 'message' => 'Xóa thương hiệu thành công!']);
    }
}
