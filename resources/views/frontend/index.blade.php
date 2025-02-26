@extends('frontend.layout')

@section('content')
    @include('frontend.slider')
    <main>
        @if ($blockServiceCate = \App\Helpers::getIndexBlockServiceCate())
        <section class="services block">
            <div class="container">
                <h2 class="block-title">{{ $blockServiceCate->name }}</h2>
                <p class="block-desc">
                    {!! $blockServiceCate->desc !!}
                </p>
                <div class="services-grid">
                    @if ($blockServiceCate->children->count() > 0)
                        @foreach ($blockServiceCate->children as $childCate)
                            <!-- Dịch thuật -->
                            <!-- 346x266 -->
                            <a href="{{ route('frontend.cate', $childCate->slug) }}" class="service-item" title="{{ $childCate->name }}">
                                <div class="service-title">
                                    <h3>{{ $childCate->name }}</h3>
                                </div>
                                <div class="background-overlay"></div>
                                <div class="service-img">
                                    <img src="{{ \App\Helpers::getImageUrlBySize($childCate->image, 346, 266) }}" alt="" class="lazyload">
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        @endif
        @if ($indexFeaturePosts = \App\Helpers::getFeatureIndexPosts())
            <section class="hot-news block">
                <div class="container">
                    <h2 class="block-title">{{ trans('frontend.index_block_feature_title') }}</h2>
                    <div class="hot-news-slider">
                        <div class="swiper-wrapper">
                            @foreach ($indexFeaturePosts as $post)
                                <div class="swiper-slide hot-news-item">
                                <a href="{{ route('frontend.post', $post->slug) }}" class="hot-news-img" title="{{ $post->name }}">
                                    <img src="{{ \App\Helpers::getImageUrlBySize($post->image, 323, 241) }}" alt="{{ $post->name }}" class="lazyload">
                                </a>
                                <div class="hot-news-detail">
                                    <a href="{{ route('frontend.post', $post->slug) }}" class="hot-new-title">{{ $post->name }}</a>
                                    <div class="hot-new-desc">
                                        <p>
                                            {!! $post->desc !!}
                                        </p>
                                    </div>
                                    <a href="{{ route('frontend.post', $post->slug) }}" class="hot-new-readmore">{{trans('frontend.view_more')}}</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="btn-next-prev">
                            <div class="hot-news-next"></div>
                            <div class="hot-news-prev"></div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if ($newsBlockPosts = \App\Helpers::getIndexNewsBlockCategoryWithPosts())
        <section class="categories block">
            <div class="container">
                <h2 class="block-title">{{ trans('frontend.category') }}</h2>
                <div class="categories-tabs">
                    @foreach ($indexFeaturePosts as $index => $infoFeature)
                        <?php dd($infoFeature); ?>
                        <button class="tab-btn {{ $index == 0 ? 'active': "" }}" data-tab="cate{{ $infoFeature['cate']->id }}">{{$infoFeature['cate']->name}}</button>
                    @endforeach
                    <button class="tab-btn more-btn" onclick="window.location.href='/news-list.html'">+</button>

                </div>

                <div class="categories-content">
                    @foreach ($indexFeaturePosts as $index => $infoFeature)
                        @if ($infoFeature['posts'])
                    <div class="tab-content {{ $index == 0 ? 'active': "" }}" id="cate{{ $infoFeature['cate']->id }}">
                        <div class="news-grid">
                            @if ($mainPost = array_shift($infoFeature['posts']))
                            <!-- Tin chính bên trái -->
                                <div class="news-main">
                                    <div class="news-img">
                                        <img src="{{ \App\Helpers::getImageUrlBySize($mainPost, 556, 432) }}" alt="{{ $mainPost->name }}" class="lazyload">
                                    </div>
                                    <a href="{{ route('frontend.post', $mainPost->slug) }}" class="news-title">{{ $mainPost->name }}</a>
                                    <div class="news-meta">{{ $mainPost->created_at->format('d/m/Y') }}</div>
                                    <div class="news-desc">
                                        <p>{{ $mainPost->desc }}</p>
                                    </div>
                                    <a href="{{ route('frontend.post', $mainPost->slug) }}" class="btn-detail">{{ trans('frontend.detail') }}</a>
                                </div>
                            @endif
                            @if ($infoFeature['posts'])
                                <!-- Danh sách tin nhỏ bên phải -->

                                <div class="news-list">
                                    <!-- Tin 1 -->
                                    @foreach ($infoFeature['posts'] as $normalPost)
                                        <div class="news-item">
                                        <div class="news-img">
                                            <img src="{{ \App\Helpers::getImageUrlBySize($normalPost, 184, 117) }}" alt="News" class="lazyload">
                                        </div>
                                        <div class="news-content">
                                            <a href="{{ route('frontend.post', $normalPost->slug) }}" class="news-title">{{ $normalPost->name }}</a>
                                            <div class="news-meta">{{ $normalPost->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </section>
        @endif
        <section class="contact-section">
            <div class="container">
                <div class="contact-info">
                    <div class="info-box">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>{!! \App\Helpers::getSettingByKey('address') !!} </p>
                    </div>
                    <div class="info-box">
                        <i class="fas fa-volume-control-phone"></i>
                        <p>{!! \App\Helpers::getSettingByKey('phone') !!}</p>
                    </div>
                    <div class="info-box">
                        <i class="fas fa-envelope"></i>
                        <p>
                            {!! \App\Helpers::getSettingByKey('email') !!}
                        </p>
                    </div>
                    <div class="info-box">
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" title="Pinterest"><i class="fab fa-pinterest"></i></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="contact-form">
                    <h2>Đăng Ký Tư Vấn</h2>
                    <form method="POST" action="{{ route('frontend.save_contact') }}">
                        {{ csrf_field() }}
                        <input type="text" name="name" placeholder="Họ và tên">
                        <input type="email" name="email" placeholder="Email">
                        <input type="tel" name="phone" placeholder="Số điện thoại">
                        <textarea name="content" placeholder="Tôi muốn tư vấn về"></textarea>
                        <button type="submit">Gửi đi</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
