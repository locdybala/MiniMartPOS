@extends('frontend.layouts.frontend_layout')

@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Đăng Ký Tài Khoản</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('frontend.home') }}">Trang chủ</a>
                            <span>Đăng ký</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header bg-primary text-white text-center">
                            <h3 class="font-weight-bold">Đăng Ký</h3>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('customer.register') }}" method="POST">
                                @csrf

                                <!-- Họ và tên -->
                                <div class="form-group">
                                    <label for="name"><i class="fa fa-user"></i> Họ và tên</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           placeholder="Nhập họ và tên" value="{{ old('name') }}" required>
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email"><i class="fa fa-envelope"></i> Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                           placeholder="Nhập email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Số điện thoại -->
                                <div class="form-group">
                                    <label for="phone"><i class="fa fa-phone"></i> Số điện thoại</label>
                                    <input type="tel" name="phone" id="phone" class="form-control"
                                           placeholder="Nhập số điện thoại" value="{{ old('phone') }}" required>
                                    @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Mật khẩu -->
                                <div class="form-group position-relative">
                                    <label for="password"><i class="fa fa-lock"></i> Mật khẩu</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control"
                                               placeholder="Nhập mật khẩu" required>
                                        <div class="input-group-append">
                                        <span class="input-group-text toggle-password" onclick="togglePassword('password')">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        </div>
                                    </div>
                                    @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Xác nhận mật khẩu -->
                                <div class="form-group position-relative">
                                    <label for="password_confirmation"><i class="fa fa-lock"></i> Xác nhận mật khẩu</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                               class="form-control" placeholder="Nhập lại mật khẩu" required>
                                        <div class="input-group-append">
                                        <span class="input-group-text toggle-password" onclick="togglePassword('password_confirmation')">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block mt-3">Đăng Ký</button>
                            </form>
                        </div>

                        <div class="card-footer text-center">
                            <small>Đã có tài khoản? <a href="{{ route('customer.login') }}" class="text-primary">Đăng nhập ngay</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function togglePassword(fieldId) {
            var passwordField = document.getElementById(fieldId);
            var eyeIcon = passwordField.nextElementSibling.querySelector("i");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>

@endsection
