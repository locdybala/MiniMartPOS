<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use Illuminate\Http\Request;

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
        ]);

        $brand = Brand::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thương hiệu đã được thêm thành công!',
            'category' => $brand
        ]);

    }

    public function update(Request $request)
    {
        // Tìm Thương hiệu theo ID
        $brand = Brand::find($request->id);

        if (!$brand) {
            return response()->json(['status' => 'error', 'message' => 'Thương hiệu không tồn tại!']);
        }

        // Cập nhật thông tin
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->status = $request->status ? 1 : 0;
        $brand->save();

        return response()->json(['status' => 'success', 'message' => 'Cập nhật Thương hiệu thành công!']);
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
