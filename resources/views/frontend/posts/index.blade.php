@extends('frontend.layouts.frontend_layout')
@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Bài viết</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('frontend.home') }}">Trang chủ</a>
                            <span>Blog</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="blog spad">
        <div class="container">
            <div class="row">
                @if($posts->count() > 0)
                    @foreach($posts as $post)
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="{{ asset('uploads/posts/' . $post->image) }}" alt="{{ $post->title }}">
                                </div>
                                <div class="blog__item__text">
                                    <ul>
                                        <li><i class="fa fa-calendar-o"></i> {{ $post->created_at->format('M d, Y') }}</li>
                                        <li><i class="fa fa-comment-o"></i> {{ $post->comments_count }}</li>
                                    </ul>
                                    <h5><a href="#">{{ $post->title }}</a></h5>
                                    <p>{{ Str::limit($post->excerpt, 100) }}</p>
                                    <a href="#" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-12 text-center">
                        <h4>Chưa có bài viết nào.</h4>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="product__pagination blog__pagination">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
