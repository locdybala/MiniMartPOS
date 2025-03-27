@extends('frontend.layouts.frontend_layout')
@section('content')

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    @foreach ($brands as $brand)
                        <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="{{ asset('storage/' . $brand->image) }}">
                                <h5><a href="#">{{ $brand->name }}</a></h5>
                            </div>
                        </div>
                    @endforeach
                    @if ($brands->isEmpty())
                        <p class="text-center">Không có thương hiệu nào.</p>
                    @endif
                </div>
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
                                <li data-filter=".{{ $category->slug }}">{{ $category->name }}</li>
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
                            // Lấy danh mục của sản phẩm dưới dạng class cho filter
                            $categoryClasses = implode(' ', $product->categories->pluck('name')->toArray());
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $categoryClasses }}">
                            <div class="featured__item">
                                <div class="featured__item__pic set-bg" data-setbg="{{ asset('storage/' . $product->image) }}">
                                    <ul class="featured__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
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
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
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
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
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
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{asset('frontend/img/blog/blog-1.jpg')}}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Cooking tips make cooking simple</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{asset('frontend/img/blog/blog-2.jpg')}}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{asset('frontend/img/blog/blog-3.jpg')}}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Visit the clean farm in the US</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
