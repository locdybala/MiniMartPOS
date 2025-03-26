<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.inventory.index', compact('products'));
    }

    public function getLowStockNotifications()
    {
        $products = Product::where('stock', '<=', 10)->get(['name', 'stock']); // Lấy sản phẩm sắp hết hàng

        return response()->json(['products' => $products]);
    }
}
