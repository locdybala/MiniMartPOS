<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\CustomerGroup;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{
    public function index() {
        $customerGroups = CustomerGroup::orderBy('id', 'desc')->get();
        return view('admin.customer_groups.index', compact('customerGroups'));
    }

    public function create() {
        return view('admin.customer_groups.create');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:customer_groups,name']);
        $customerGroup = CustomerGroup::create([
            'name' => $request->name,
            'status' => $request->status ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nhóm khách hàng đã được tạo!',
            'customerGroup' => $customerGroup
        ]);
    }

    public function edit(CustomerGroup $customerGroup) {
        return view('admin.customer_groups.edit', compact('customerGroup'));
    }

    public function update(Request $request, CustomerGroup $customerGroup) {
        $request->validate(['name' => 'required|unique:customer_groups,name,' . $customerGroup->id]);
        $customerGroup->update([
            'name' => $request->name,
            'status' => $request->status ?? 1,
        ]);
        return response()->json(['status' => 'success', 'message' => 'Cập nhật loại khách hàng thành công!']);
    }

    public function destroy(CustomerGroup $customerGroup) {
        $customerGroup->delete();
        return response()->json(['status' => 'success', 'message' => 'Xóa nhóm khách hàng thành công!']);
    }
}
