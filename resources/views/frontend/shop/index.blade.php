@extends('frontend.layouts.frontend_layout')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>
                            @isset($category)
                                {{ $category->name }}
                            @else
                                Danh sách sản phẩm
                            @endisset
                        </h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('frontend.home') }}">Trang chủ</a>
                            <span>Cửa hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Danh mục</h4>
                            <ul>
                                @foreach($categories as $category)
                                <li><a href="{{route('shop.categoryList', ['id' => $category->id])}}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>Sản phẩm mới nhất</h4>
                                <div class="latest-product__slider owl-carousel">
                                    @foreach ($latestProducts->chunk(3) as $productChunk)
                                        <div class="latest-prdouct__slider__item">
                                            @foreach ($productChunk as $product)
                                                <a href="" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" alt="{{ $product->name }}">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6>{{ $product->name }}</h6>
                                                        <span>{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sắp xếp</span>
                                    <select id="sort-price">
                                        <option value="">-- Sắp xếp theo --</option>
                                        <option value="asc">Giá tăng dần</option>
                                        <option value="desc">Giá giảm dần</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span>{{$products->count()}}</span> sản phẩm</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row div-search">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item" data-price="{{ $product->price }}">
                                    <div class="product__item__pic set-bg" data-setbg="{{ asset('storage/'.$product->images->first()->image_path) }}">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="#" class="add-to-cart" data-id="{{ $product->id }}" data-stock="{{$product->stock}}"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h6>
                                        <h5>{{ number_format($product->price, 0, ',', '.') }} VNĐ</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="product__pagination">
                        @if ($products->lastPage() > 1)
                            @for ($i = 1; $i <= $products->lastPage(); $i++)
                                <a href="{{ $products->url($i) }}" class="{{ ($products->currentPage() == $i) ? 'active' : '' }}">{{ $i }}</a>
                            @endfor
                            @if ($products->currentPage() < $products->lastPage())
                                <a href="{{ $products->nextPageUrl() }}"><i class="fa fa-long-arrow-right"></i></a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
@section('js')
    <script>
        $('#sort-price').on('change', function () {
            let sortType = $(this).val();
            let container = $('.div-search'); // chỗ chứa các sản phẩm
            let products = container.find('.product__item').parent(); // mỗi .col-lg-4...

            let sorted = products.sort(function(a, b) {
                let priceA = parseFloat($(a).find('.product__item').data('price'));
                let priceB = parseFloat($(b).find('.product__item').data('price'));
                return sortType === 'asc' ? priceA - priceB : priceB - priceA;
            });

            container.html(sorted);
        });

        $(document).ready(function(){
            $(".add-to-cart").on("click", function(e){
                e.preventDefault();
                var productId = $(this).data("id");
                var stock = $(this).data("stock");
                // Lấy số lượng từ ô nhập, nếu có. Nếu không có thì mặc định là 1.
                var quantity = $(".pro-qty input").val() || 1;
                if (quantity > stock) {
                    toastr["error"]("Sản phẩm đã hết hàng " + stock);
                    return;
                }
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
