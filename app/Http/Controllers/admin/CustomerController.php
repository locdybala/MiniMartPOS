<?php

namespace App\Http\Controllers\admin;

use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        $customerGroups= CustomerGroup::all();
        return view('admin.customers.create',compact('customerGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customer,email',
            'phone' => 'nullable|string|max:20',
        ]);

        Customer::create($request->all());

        return redirect()->route('customer.index')->with('success', 'Khách hàng đã được thêm!');
    }

    public function edit(Customer $customer)
    {
        $customerGroups= CustomerGroup::all();
        return view('admin.customers.create', compact('customer', 'customerGroups'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customer,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $customer->update($request->all());

        return redirect()->route('customer.index')->with('success', 'Khách hàng đã được cập nhật!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => 'Xóa thành công!']);
    }

    public function getCustomers()
    {
        $customers = Customer::select('id', 'name', 'phone')->get();
        return response()->json($customers);
    }

    public function orders()
    {
        $orders = Order::where('customer_id', Auth::guard('customer')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.customer.historyorder', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('details')->findOrFail($id);

        return view('frontend.customer.showdetailorder', compact('order'));
    }
}
