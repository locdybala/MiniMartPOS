@extends('frontend.layouts.frontend_layout')
@section('content')
    <!-- Blog Details Hero Begin -->
    <section class="blog-details-hero set-bg" data-setbg="{{ asset('storage/' . $post->image) }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog__details__hero__text">
                        <h2>{{ $post->title }}</h2>
                        <ul>
                            <li>By Admin</li>
                            <li>{{ $post->created_at->format('F d, Y') }}</li>
                            <li>0 Comments</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <!-- Sidebar (bạn có thể giữ nguyên nếu dùng) -->

                <div class="col-lg-12 col-md-7 order-md-1 order-1">
                    <div class="blog__details__text">
                        <p>{!! $post->content !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

@endsection
