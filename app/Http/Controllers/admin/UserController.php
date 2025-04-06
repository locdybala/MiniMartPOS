<?php

namespace App\Http\Controllers\admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->latest()->paginate(10); // Lấy danh sách user với phân trang

        return view('admin.users.index', compact('users'));
    }

    // Hiển thị form thêm người dùng
    public function create()
    {
        $roles = Role::all(); // Lấy tất cả vai trò
        return view('admin.users.create', compact('roles'));
    }

    // Lưu người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        $request->password = bcrypt($request->password);
        User::create($request->all());

        return redirect()->route('users.index')->with('success', 'Thêm người dùng thành công');
    }



    // Hiển thị form chỉnh sửa người dùng
    public function edit(User $user)
    {
        $roles = Role::all(); // Lấy tất cả vai trò
        return view('admin.users.create', compact('user', 'roles'));
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($request->has('password')) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công');
    }

    // Xóa người dùng
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with(['message' => 'Xóa thành công!']);
    }
}
