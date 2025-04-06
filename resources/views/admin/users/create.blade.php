@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        @php
            $title = isset($user) ? 'Chỉnh sửa người dùng' : 'Thêm người dùng';
            $action = isset($user) ? 'Cập nhật' : 'Thêm';
        @endphp
        @include('admin.components.page-header', ['title' => 'Người dùng', 'action' => $action])

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $action . ' Người dùng' }}</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                            @csrf
                            @if(isset($user))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="name">Tên người dùng</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name ?? '' }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ $user->email ?? '' }}">
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" id="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
                            </div>

                            <div class="form-group">
                                <label for="role_id">Vai trò</label>
                                <select name="role_id" id="role_id" class="form-control">
                                    <option value="">Chọn vai trò</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ isset($user) && $user->role_id == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="card-action">
                                <button type="submit" class="btn btn-success">{{ isset($user) ? 'Cập nhật' : 'Thêm' }}</button>
                                <a href="{{ route('users.index') }}" class="btn btn-danger">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
