@extends('admin.layouts.admin-layout')
@section('content')
    <div class="page-inner">
        @php
            $title = isset($post) ? 'Chỉnh sửa bài viết' : 'Thêm bài viết';
            $action = isset($post) ? 'Cập nhật ' : 'Thêm ';
        @endphp
        @include('admin.components.page-header', ['title' => 'Bài viết', 'action' => $action])

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $action . 'Bài viết' }}</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($post))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label>Tiêu đề bài viết</label>
                                <input type="text" name="title" class="form-control" value="{{ $post->title ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ $post->slug ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="contents" class="form-control editor">{{ $post->content ?? '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <input type="file" name="image" id="postImage" class="form-control">
                                @if(isset($post) && $post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editStatusCategory">
                                </div>
                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">{{ isset($post) ? 'Cập nhật' : 'Thêm' }}</button>
                                <a href="{{ route('posts.index') }}" class="btn btn-danger">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('contents');
        });
    </script>
@endsection
