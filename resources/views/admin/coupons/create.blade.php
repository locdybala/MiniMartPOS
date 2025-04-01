@extends('admin.layouts.admin-layout')
@section('content')
    <div class="page-inner">
        @php
            $title = isset($coupon) ? 'Chỉnh sửa mã giảm giá' : 'Thêm mã giảm giá';
            $action = isset($coupon) ? 'Cập nhật ' : 'Thêm ';
        @endphp
        @include('admin.components.page-header', ['title' => 'Mã giảm giá', 'action' => $action])

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $action . 'Mã giảm giá' }}</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($coupon) ? route('coupons.update', $coupon->id) : route('coupons.store') }}" method="POST">
                            @csrf
                            @if(isset($coupon))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tên mã giảm giá</label>
                                        <input type="text" name="coupon_name" class="form-control" value="{{ $coupon->coupon_name ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Số lượng mã giảm giá</label>
                                        <input type="number" name="coupon_time" class="form-control" value="{{ $coupon->coupon_time ?? '' }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Điều kiện giảm giá</label>
                                        <select name="coupon_condition" class="form-control select2">
                                            <option value="1" {{ isset($coupon) && $coupon->coupon_condition == 1 ? 'selected' : '' }}>Giảm theo %</option>
                                            <option value="2" {{ isset($coupon) && $coupon->coupon_condition == 2 ? 'selected' : '' }}>Giảm theo tiền</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Số lượng giảm</label>
                                        <input type="text" name="coupon_number" class="form-control" value="{{ $coupon->coupon_number ?? '' }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mã giảm giá</label>
                                        <input type="text" name="coupon_code" class="form-control" value="{{ $coupon->coupon_code ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ngày bắt đầu</label>
                                        <input type="date" name="coupon_date_start" class="form-control" value="{{ $coupon->coupon_date_start ?? '' }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ngày kết thúc</label>
                                        <input type="date" name="coupon_date_end" class="form-control" value="{{ $coupon->coupon_date_end ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="status" {{ isset($coupon) && $coupon->status ? 'checked' : '' }}>
                                            <label class="form-check-label">Kích hoạt</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-action">
                                <button type="submit" class="btn btn-success">{{ isset($coupon) ? 'Cập nhật' : 'Thêm' }}</button>
                                <a href="{{ route('coupons.index') }}" class="btn btn-danger">Hủy</a>
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
