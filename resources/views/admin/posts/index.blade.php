@extends('admin.layouts.admin-layout')
@section('content')
    <div class="page-inner">
        @php
            $title = 'Bài viết';
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
                            <a href="{{ route('posts.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Thêm mới
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tiêu đề</th>
                                    <th>Hình ảnh</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th style="width: 15%">Thao tác</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>STT</th>
                                    <th>Tiêu đề</th>
                                    <th>Hình ảnh</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($posts as $post)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td><img src="{{ asset('uploads/posts/' . $post->image) }}" width="80" alt="{{ $post->title }}"></td>
                                        <td>
                                            @if($post->status == 1)
                                                <span class="badge bg-success">Hiển thị</span>
                                            @else
                                                <span class="badge bg-danger">Ẩn</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-link btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
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
