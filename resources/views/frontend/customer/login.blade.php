@extends('frontend.layouts.frontend_layout')

@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Đăng nhập</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('frontend.home') }}">Trang chủ</a>
                            <span>Đăng nhập</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="login-section spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="login__form">
                        <h3 class="text-center mb-4">Đăng nhập tài khoản</h3>
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('customer.login.post') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Nhập email">
                            </div>
                            <div class="form-group position-relative">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Nhập mật khẩu">
                                <span class="toggle-password" onclick="togglePassword()">
                                    <i class="fa fa-eye" id="eyeIcon"></i>
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{route('customer.forgot')}}">Quên mật khẩu?</a>
                        </div>
                        <div class="text-center mt-2">
                            <span>Chưa có tài khoản? </span>
                            <a href="{{route('customer.register')}}">Đăng ký ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .login__form {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>

    <script>
        function togglePassword() {
            let passwordField = document.getElementById("password");
            let eyeIcon = document.getElementById("eyeIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
