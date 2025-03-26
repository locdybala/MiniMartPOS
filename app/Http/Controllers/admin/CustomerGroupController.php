<?php

namespace App\Http\Controllers\admin;

use App\Models\CustomerGroup;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{
    public function index() {
        $customerGroups = CustomerGroup::all();
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
        return redirect()->route('customer_groups.index')->with('success', 'Nhóm khách hàng đã được tạo!');
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
        return redirect()->route('customer_groups.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(CustomerGroup $customerGroup) {
        $customerGroup->delete();
        return redirect()->route('customer_groups.index')->with('success', 'Xóa thành công!');
    }
}
