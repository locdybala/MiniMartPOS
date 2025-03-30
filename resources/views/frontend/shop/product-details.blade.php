@extends('frontend.layouts.frontend_layout')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{asset('frontend/img/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Vegetable’s Package</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <a href="./index.html">Vegetables</a>
                            <span>Vegetable’s Package</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                 src="{{ asset('storage/'.$product->images->first()->image_path) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            @foreach($product->images as $image)
                                <img data-imgbigurl="{{ asset('storage/'.$image->image_path) }}"
                                     src="{{ asset('storage/'.$image->image_path) }}" alt="{{ $product->name }}">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>{{ $product->name }}</h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        <div class="product__details__price">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                        <p>{{ $product->description }}</p>
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                            </div>
                        </div>
                        <button class="btn primary-btn add-to-cart" data-id="{{ $product->id }}">THÊM VÀO GIỎ HÀNG</button>
                        <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                        <ul>
                            <li><b>Trạng thái</b> <span>{{ $product->stock > 0 ? 'Còn hàng' : 'Hết hàng' }}</span></li>
                            <li><b>Vận chuyển</b> <span>Giao hàng trong 1 ngày. <samp>Nhận hàng miễn phí</samp></span></li>
                            <li><b>Trọng lượng</b> <span>{{ $product->weight }} kg</span></li>
                            <li><b>Chia sẻ</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                   aria-selected="true">Mô tả</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                   aria-selected="false">Thông tin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                   aria-selected="false">Đánh giá <span>(1)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Thông tin sản phẩm</h6>
                                    <p>{{ $product->description }}</p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Thông tin bổ sung</h6>
                                    <p>Trọng lượng: {{ $product->weight }} kg</p>
                                    <p>Kích thước: {{ $product->size }}</p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Đánh giá sản phẩm</h6>

                                    <!-- Danh sách đánh giá -->
                                    @foreach($product->reviews as $review)
                                        <div class="review">
                                            <strong>{{ $review->customer->name ?? 'Khách hàng ẩn danh' }}</strong> -
                                            <span>{{ $review->rating }} ⭐</span>
                                            <p>{{ $review->comment }}</p>
                                        </div>
                                        <hr>
                                    @endforeach

                                    <!-- Form thêm đánh giá -->
                                    @if(Auth::guard('customer')->check())
                                        <form action="{{ route('product.review', $product->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="rating">Chọn số sao:</label>
                                                <select name="rating" id="rating" class="form-control" required>
                                                    <option value="5">5 Sao</option>
                                                    <option value="4">4 Sao</option>
                                                    <option value="3">3 Sao</option>
                                                    <option value="2">2 Sao</option>
                                                    <option value="1">1 Sao</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="comment">Nội dung đánh giá:</label>
                                                <textarea name="comment" id="comment" rows="3" class="form-control" required></textarea>
                                            </div>
                                            <button type="submit" class="primary-btn">Gửi đánh giá</button>
                                        </form>
                                    @else
                                        <p><a href="{{ route('customer.login') }}">Đăng nhập</a> để đánh giá sản phẩm.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Product Details Section End -->

    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Sản phẩm liên quan</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($relatedProducts->isEmpty())
                    <div class="col-lg-12 text-center">
                        <p>Không có sản phẩm nào.</p>
                    </div>
                @else
                    @foreach($relatedProducts as $related)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ asset('storage/'.$product->images->first()->image_path) }}">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{ route('product.details', $related->id) }}">{{ $related->name }}</a></h6>
                                    <h5>{{ number_format($related->price, 0, ',', '.') }} đ</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
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
                        alert(response.message);
                        $("#cart-count").text(response.cartTotalQuantity);
                    },
                    error: function(xhr){
                        alert("Có lỗi xảy ra, vui lòng thử lại sau!");
                    }
                });
            });
        });
    </script>
@endsection
