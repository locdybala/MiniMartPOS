<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('user')->orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Danh mục đã được thêm thành công!',
            'category' => $category
        ]);

    }

    public function update(Request $request)
    {
        $group = Category::findOrFail($request->id);
        $group->name = $request->name;
        $group->status = $request->status;
        $group->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật danh mục thành công']);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Danh mục không tồn tại!']);
        }

        $category->delete();
        return response()->json(['status' => 'success', 'message' => 'Xóa danh mục thành công!']);
    }
}
