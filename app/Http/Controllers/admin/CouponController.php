<?php

namespace App\Http\Controllers\admin;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    // Hiển thị danh sách mã giảm giá
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    // Hiển thị form thêm mã giảm giá
    public function create()
    {
        return view('admin.coupons.create');
    }

    // Lưu mã giảm giá mới
    public function store(Request $request)
    {
        $request->validate([
            'coupon_name' => 'required',
            'coupon_code' => 'required|unique:coupons',
            'coupon_time' => 'required|integer',
            'coupon_condition' => 'required|in:1,2',
            'coupon_number' => 'required|numeric',
            'coupon_date_start' => 'required|date',
            'coupon_date_end' => 'required|date',
        ]);

        Coupon::create([
            'coupon_name' => $request->coupon_name,
            'coupon_code' => $request->coupon_code,
            'coupon_time' => $request->coupon_time,
            'coupon_condition' => $request->coupon_condition,
            'coupon_number' => $request->coupon_number,
            'coupon_date_start' => $request->coupon_date_start,
            'coupon_date_end' => $request->coupon_date_end,
        ]);

        return redirect()->route('coupons.index')->with('success', 'Thêm mã giảm giá thành công');
    }

    // Hiển thị form sửa mã giảm giá
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.create', compact('coupon'));
    }

    // Cập nhật mã giảm giá
    public function update(Request $request, $id)
    {
        $request->validate([
            'coupon_name' => 'required',
            'coupon_code' => 'required|unique:coupons,coupon_code,' . $id,
            'coupon_time' => 'required|integer',
            'coupon_condition' => 'required|in:1,2',
            'coupon_number' => 'required|numeric',
            'coupon_date_start' => 'required|date',
            'coupon_date_end' => 'required|date',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'coupon_name' => $request->coupon_name,
            'coupon_code' => $request->coupon_code,
            'coupon_time' => $request->coupon_time,
            'coupon_condition' => $request->coupon_condition,
            'coupon_number' => $request->coupon_number,
            'coupon_date_start' => $request->coupon_date_start,
            'coupon_date_end' => $request->coupon_date_end,
        ]);

        return redirect()->route('coupons.index')->with('success', 'Cập nhật mã giảm giá thành công');
    }

    // Xóa mã giảm giá
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Xóa mã giảm giá thành công');
    }
}
