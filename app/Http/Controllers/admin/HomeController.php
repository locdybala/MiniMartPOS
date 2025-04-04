<?php

namespace App\Http\Controllers\admin;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Tổng số khách hàng
        $totalCustomers = Customer::count();

        // Tổng số người đăng ký (Subscribers) - nếu có trường `is_subscribed` trong bảng users
        $totalSubscribers = User::count();

        // Doanh thu: Tổng tiền của các đơn hàng đã thanh toán
        $totalSales = Order::where('payment_status', 'paid')->sum('final_total');

        // Tổng số đơn hàng đã được tạo
        $totalOrders = Order::count();

        // Lấy 5 khách hàng mới nhất
        $newCustomers = User::latest()->take(5)->get();

        // Lấy các đơn hàng gần đây
        $orders = Order::orderBy('created_at', 'desc')->limit(10)->get();

        $onlineUsers = Customer::where('last_activity', '>=', now()->subMinutes(5))->count();


        return view('admin.dashboard',  compact('totalOrders', 'totalSales', 'totalCustomers', 'totalSubscribers', 'newCustomers', 'orders', 'onlineUsers'));
    }

    public function getStatisticsData()
    {
        $monthlyData = DB::table('orders')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(id) as total_orders')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $purchaseData = DB::table('import_orders')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(id) as total_purchases')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $salesData = DB::table('order_details')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(quantity) as total_sold')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $purchasesData = DB::table('import_order_details')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(quantity) as total_purchased')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $months = range(1, 12);
        $revenue = [];
        $totalOrders = [];
        $totalPurchases = [];
        $totalSold = [];
        $totalPurchased = [];

        foreach ($months as $month) {
            $revenue[] = $monthlyData[$month]->revenue ?? 0;
            $totalOrders[] = $monthlyData[$month]->total_orders ?? 0;
            $totalPurchases[] = $purchaseData[$month]->total_purchases ?? 0;
            $totalSold[] = $salesData[$month]->total_sold ?? 0;
            $totalPurchased[] = $purchasesData[$month]->total_purchased ?? 0;
        }

        return response()->json([
            'revenue' => $revenue,
            'totalOrders' => $totalOrders,
            'totalPurchases' => $totalPurchases,
            'totalSold' => $totalSold,
            'totalPurchased' => $totalPurchased,
        ]);
    }
}
