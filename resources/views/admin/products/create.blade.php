@extends('admin.layouts.admin-layout')
@section('content')
    <div class="page-inner">
        @php
            $title = isset($product) ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm';
            $action = isset($product) ? 'Cập nhật ' : 'Thêm ';
        @endphp
        @include('admin.components.page-header', ['title' => 'Sản phẩm', 'action' => $action])

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $action . 'Sản phẩm' }}</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($product))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tên sản phẩm</label>
                                        <input type="text" name="name" class="form-control" value="{{ $product->name ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Danh mục</label>
                                        <select name="category_id" class="form-control select2">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Thương hiệu</label>
                                        <select name="brand_id" class="form-control select2">
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ isset($product) && $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Giá sản phẩm</label>
                                        <input type="text" name="price" class="form-control format-price" value="{{ $product->price ?? '' }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Số lượng tồn kho</label>
                                        <input type="number" name="stock" class="form-control" value="{{ $product->stock ?? '0' }}" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="status" {{ isset($product) && $product->status ? 'checked' : '' }}>
                                            <label class="form-check-label">Kích hoạt</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Hình ảnh sản phẩm</label>
                                <input type="file" name="images[]" id="productImages" multiple class="form-control">
                                <div id="previewImages" class="mt-2 d-flex flex-wrap" data-images="{{ isset($product) ? json_encode($product->images->pluck('image_path')) : '[]' }}"></div>
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea name="description" class="form-control editor">{{ $product->description ?? '' }}</textarea>
                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">{{ isset($product) ? 'Cập nhật' : 'Thêm' }}</button>
                                <a href="{{ route('products.index') }}" class="btn btn-danger">Hủy</a>
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
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('imagePreview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
        $(document).ready(function() {
            $('.select2').select2();
            $('.format-price').on('input', function() {
                let value = this.value.replace(/,/g, '');
                this.value = new Intl.NumberFormat('vi-VN').format(value);
            });
        });
        $(document).ready(function() {
            let preview = $('#previewImages');
            let images = preview.data('images');

            if (Array.isArray(images) && images.length > 0) {
                images.forEach(path => {
                    let imgUrl = `/storage/${path}`; // Đảm bảo đường dẫn hợp lệ
                    let img = $('<img>', {
                        src: imgUrl,
                        class: 'img-thumbnail m-1',
                        css: { width: '100px', height: '100px', objectFit: 'cover' }
                    });
                    preview.append(img);
                });
            }

            $('#productImages').on('change', function(event) {
                preview.empty();
                $.each(event.target.files, function(index, file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let img = $('<img>', {
                            src: e.target.result,
                            class: 'img-thumbnail m-1',
                            css: { width: '100px', height: '100px', objectFit: 'cover' }
                        });
                        preview.append(img);
                    };
                    reader.readAsDataURL(file);
                });
            });
        });

    </script>
@endsection
