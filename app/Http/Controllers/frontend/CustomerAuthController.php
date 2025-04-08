<?php

namespace App\Http\Controllers\frontend;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.customer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('customer')->attempt($credentials)) {
// Cập nhật thời gian hoạt động của người dùng
            $user = Auth::guard('customer')->user();
            $user->update(['last_activity' => now()]);
            return redirect()->route('frontend.home')->with('success', 'Đăng nhập thành công');
        }

        return back()->with('error', 'Email hoặc mật khẩu không chính xác');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login')->with('success', 'Đã đăng xuất');
    }

    public function showRegisterForm()
    {
        return view('frontend.customer.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Tạo tài khoản khách hàng
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'customer_group_id' => 2,
            'phone' => $request->phone
        ]);

        // Đăng nhập sau khi đăng ký thành công
        Auth::guard('customer')->login($customer);

        // Chuyển hướng về trang chủ hoặc trang tài khoản
        return redirect()->route('frontend.home')->with('success', 'Đăng ký thành công!');
    }

    public function showForgotForm() {
        return view('frontend.customer.forgot');
    }

    public function sendResetLink(Request $request) {
        $request->validate(['email' => 'required|email|exists:customers,email']);

        $status = Password::broker('customers')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
