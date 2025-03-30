@extends('frontend.layouts.frontend_layout')
@section('content')
    <section class="password-reset-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="password-reset-form">
                        <h2>Quên Mật Khẩu</h2>
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif
                        <form action="{{ route('customer.send_email') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi liên kết đặt lại mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
