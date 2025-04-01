@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        @php
            $title = 'Mã giảm giá';
            $i = 0;
            $action = 'Danh sách';
        @endphp
        @include('admin.components.page-header', ['title' => $title, 'action' => $action])
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Quản lý {{$title}}</h4>
                            <a href="{{ route('coupons.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                @include('admin.components.alert')
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên mã giảm giá</th>
                                    <th>Mã giảm giá</th>
                                    <th>Điều kiện</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên mã giảm giá</th>
                                    <th>Mã giảm giá</th>
                                    <th>Điều kiện</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Thao tác</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($coupons as $coupon)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $coupon->coupon_name }}</td>
                                        <td>{{ $coupon->coupon_code }}</td>
                                        <td>
                                            @if($coupon->coupon_condition == 1)
                                                Giảm theo %
                                            @else
                                                Giảm theo tiền
                                            @endif
                                        </td>
                                        <td>{{ $coupon->coupon_date_start }}</td>
                                        <td>{{ $coupon->coupon_date_end }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('coupons.edit', $coupon) }}" class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('coupons.destroy', $coupon) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-danger deleteCoupon" data-id="{{ $coupon->id }}"><i class="fa fa-times"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
