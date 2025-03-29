@extends('admin.layouts.admin-layout')

@section('content')
    <div class="page-inner">
        @php
            $title = isset($customer) ? 'Chỉnh sửa khách hàng' : 'Thêm khách hàng';
            $action = isset($customer) ? 'Cập nhật ' : 'Thêm ';
        @endphp
        @include('admin.components.page-header', ['title' => 'Khách hàng', 'action' => $action])

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $action . 'Khách hàng' }}</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($customer) ? route('customer.update', $customer->id) : route('customer.store') }}" method="POST">
                            @csrf
                            @if(isset($customer))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label>Tên khách hàng</label>
                                <input type="text" name="name" class="form-control" value="{{ $customer->name ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $customer->email ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" value="{{ $customer->phone ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Nhóm khách hàng</label>
                                <select name="customer_group_id" class="form-control select2">
                                    <option value="">Chọn nhóm</option>
                                    @foreach($customerGroups as $group)
                                        <option value="{{ $group->id }}" {{ isset($customer) && $customer->customer_group_id == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">{{ isset($customer) ? 'Cập nhật' : 'Thêm' }}</button>
                                <a href="{{ route('customer.index') }}" class="btn btn-danger">Hủy</a>
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
