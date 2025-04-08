@extends('frontend.layouts.frontend_layout')
@section('content')

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                @if ($brands->isNotEmpty())
                    <div class="categories__slider owl-carousel">
                        @foreach ($brands as $brand)
                            <div class="categories__item set-bg" style="width: 262px;" data-setbg="{{ asset('storage/' . $brand->image) }}">
                                <h5><a href="#">{{ $brand->name }}</a></h5>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="col-lg-12 text-center">
                        <p>Không có thương hiệu nào.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Danh sách sản phẩm</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">Tất cả</li>
                            @foreach ($categories as $category)
                                <li data-filter=".{{ Str::slug($category->name, '_') }}">{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                @if ($listProducts->isEmpty())
                    <p class="text-center">Không có sản phẩm nào.</p>
                @else
                    @foreach ($listProducts as $product)
                        @php
                            // Chuyển danh mục thành slug
                            $categoryClasses = Str::slug($product->category->name, '_');
                        @endphp

                        <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $categoryClasses }}">
                            <div class="featured__item">
                                <div class="featured__item__pic set-bg" data-setbg="{{ asset('storage/'.$product->images->first()->image_path) }}">
                                    <ul class="featured__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                        <li><a href="#" class="add-to-cart" data-id="{{ $product->id }}"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="featured__item__text">
                                    <h6><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h6>
                                    <h5>{{ number_format($product->price, 0, ',', '.') }} VNĐ</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{asset('frontend/img/banner/banner-1.jpg')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{asset('frontend/img/banner/banner-2.jpg')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="latest-product__text">
                        <h4>Sản phẩm mới nhất</h4>
                        <div class="latest-product__slider owl-carousel">
                            @if ($latestProducts->isEmpty())
                                <p class="text-center">Không có sản phẩm nào.</p>
                            @else
                                <div class="latest-prdouct__slider__item">
                                    @foreach ($latestProducts as $product)
                                        <a href="{{ route('product.details', $product->id) }}" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" alt="{{ $product->name }}">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>{{ $product->name }}</h6>
                                                <span>{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                            </div>
                                        </a>
                                        @if ($loop->iteration % 3 == 0 && !$loop->last)
                                </div><div class="latest-prdouct__slider__item">
                                    @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="latest-product__text">
                        <h4>Đánh giá cao</h4>
                        <div class="latest-product__slider owl-carousel">
                            @if ($topRatedProducts->isEmpty())
                                <p class="text-center">Không có sản phẩm nào.</p>
                            @else
                                <div class="latest-prdouct__slider__item">
                                    @foreach ($topRatedProducts as $product)
                                        <a href="{{ route('product.details', $product->id) }}" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" alt="{{ $product->name }}">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>{{ $product->name }}</h6>
                                                <span>{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                            </div>
                                        </a>
                                        @if ($loop->iteration % 3 == 0 && !$loop->last)
                                </div><div class="latest-prdouct__slider__item">
                                    @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>Bài viết</h2>
                    </div>
                </div>
            </div>

            @if($latestPosts->isEmpty())
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p>Hiện chưa có bài viết nào.</p>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach($latestPosts as $post)
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                                </div>
                                <div class="blog__item__text">
                                    <ul>
                                        <li><i class="fa fa-calendar-o"></i> {{ $post->created_at->format('d/m/Y') }}</li>
                                    </ul>
                                    <h5><a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a></h5>
                                    <p>{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $(".add-to-cart").on("click", function(e){
                e.preventDefault();
                var productId = $(this).data("id");
                // Lấy số lượng từ ô nhập, nếu có. Nếu không có thì mặc định là 1.
                var quantity = $(".pro-qty input").val() || 1;

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response){
                        // Hiển thị thông báo hoặc cập nhật giỏ hàng header
                        toastr["success"](response.message);
                        $("#cart-count").text(response.cartTotalQuantity);
                    },
                    error: function(xhr){
                        toastr["error"]("Có lỗi xảy ra, vui lòng thử lại sau!");
                    }
                });
            });
        });
    </script>
@endsection
