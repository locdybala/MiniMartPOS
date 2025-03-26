<?php

namespace App\Http\Controllers\admin;

use App\Models\ImportOrder;
use App\Models\ImportOrderDetail;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportOrderController extends Controller
{
    // Hiển thị danh sách phiếu nhập hàng
    public function index()
    {
        $importOrders = ImportOrder::with('supplier')->orderBy('import_date', 'desc')->get();
        return view('admin.import_orders.index', compact('importOrders'));
    }

    // Hiển thị form thêm phiếu nhập
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('admin.import_orders.create', compact('suppliers', 'products'));
    }

    // Lưu phiếu nhập hàng vào database
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'import_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $importOrder = ImportOrder::create([
                'supplier_id' => $request->supplier_id,
                'import_date' => $request->import_date,
                'total_amount' => collect($request->products)->sum(fn($p) => $p['quantity'] * $p['unit_price']),
            ]);

            foreach ($request->products as $product) {
                ImportOrderDetail::create([
                    'import_order_id' => $importOrder->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['unit_price'],
                ]);

                // Cập nhật số lượng tồn kho sản phẩm
                Product::where('id', $product['product_id'])->increment('stock', $product['quantity']);
            }
        });

        return redirect()->route('import-orders.index')->with('success', 'Nhập hàng thành công!');
    }

    // Hiển thị chi tiết phiếu nhập hàng
    public function show($id)
    {
        $importOrder = ImportOrder::with(['supplier', 'details.product'])->findOrFail($id);
        return view('admin.import_orders.show', compact('importOrder'));
    }
    public function edit($id)
    {
        $importOrder = ImportOrder::with('supplier')->findOrFail($id);
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('admin.import_orders.create', compact('importOrder', 'suppliers', 'products'));
    }

    // Cập nhật phiếu nhập hàng
    // Cập nhật phiếu nhập hàng và cập nhật số lượng sản phẩm
    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'import_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
        ]);

        $importOrder = ImportOrder::findOrFail($id);

        // Lấy chi tiết phiếu nhập cũ và hoàn tác số lượng sản phẩm
        foreach ($importOrder->details as $detail) {
            $product = Product::find($detail->product_id);
            if ($product) {
                $product->quantity -= $detail->quantity; // Trừ đi số lượng cũ
                $product->save();
            }
        }

        // Cập nhật thông tin phiếu nhập
        $importOrder->update($request->only(['supplier_id', 'import_date', 'total_amount']));

        // Xóa chi tiết phiếu nhập cũ
        $importOrder->details()->delete();

        // Thêm chi tiết mới và cập nhật số lượng sản phẩm
        foreach ($request->products as $productData) {
            $importOrder->details()->create([
                'product_id' => $productData['id'],
                'quantity' => $productData['quantity'],
                'price' => $productData['price'] ?? 0,
            ]);

            // Cập nhật lại số lượng tồn kho
            $product = Product::find($productData['id']);
            if ($product) {
                $product->quantity += $productData['quantity'];
                $product->save();
            }
        }

        return redirect()->route('import-orders.index')->with('success', 'Cập nhật phiếu nhập hàng thành công.');
    }
    // Xóa phiếu nhập hàng
    public function destroy($id)
    {
        $importOrder = ImportOrder::findOrFail($id);
        DB::transaction(function () use ($importOrder) {
            foreach ($importOrder->details as $detail) {
                // Giảm số lượng tồn kho khi xóa phiếu nhập
                Product::where('id', $detail->product_id)->decrement('stock', $detail->quantity);
            }

            $importOrder->details()->delete();
            $importOrder->delete();
        });

        return redirect()->route('import-orders.index')->with('success', 'Xóa phiếu nhập thành công!');
    }
}
