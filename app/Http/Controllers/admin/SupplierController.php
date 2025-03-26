<?php

namespace App\Http\Controllers\admin;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:suppliers,email',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'taxcode' => 'nullable|string|max:50'
        ]);

        $supplier = Supplier::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'description' => $request->description,
            'taxcode' => $request->taxcode
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nhà cung cấp đã được thêm thành công!',
            'supplier' => $supplier
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        try {
            // Validate dữ liệu
            $request->validate([
                'id' => 'required|exists:suppliers,id',
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'taxcode' => 'nullable|string|max:50',
            ]);

            // Lấy nhà cung cấp theo ID
            $supplier = Supplier::findOrFail($request->id);

            // Cập nhật thông tin nhà cung cấp
            $supplier->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'description' => $request->description,
                'taxcode' => $request->taxcode,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật nhà cung cấp thành công!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra! Vui lòng thử lại.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Tìm nhà cung cấp theo ID
            $supplier = Supplier::findOrFail($id);

            // Xóa nhà cung cấp
            $supplier->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa nhà cung cấp thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra, không thể xóa!',
            ], 500);
        }
    }
}
