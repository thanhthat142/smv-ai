@extends('frontend.layout')

@section('content')
    <main>
        <section class="block detail-news-page">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('frontend.index') }}">{{ trans('frontend.index') }}</a></li>
                    <li><a href="{{ route('frontend.cate', $post->category->slug) }}">{{ $post->category->name }}</a></li>
                </ul>
                <div class="news-detail-content">
                    <h1 class="news-title">{{ $post->name }}</h1>

                    <div class="news-meta">
                        <span class="date"><i class="far fa-calendar-alt"></i> {{ $post->created_at->format('d/m/Y') }}</span>
                        <span class="views"><i class="far fa-eye"></i> {{ $post->views }} {{ trans('frontend.post_detail_view') }}</span>
                    </div>

                    <div class="news-summary">
                        {!! $post->summary !!}
                    </div>

                    <div class="news-body">
                        {!! $post->content !!}
                    </div>

                    @if ($post->tags->count() > 0)
                        <div class="news-tags">
                            <span>{{ trans('frontend.post_tag') ?? 'Các nhãn dán' }}:</span>
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('frontend.tag', $tag->slug) }}">#{{ $tag->name }}</a>
                            @endforeach

                        </div>
                    @endif

{{--                    <div class="news-share">--}}
{{--                        <span>Share:</span>--}}
{{--                        <a href="{{ \App\Helpers::getSettingByKey('facebook_link') }}" class="facebook"><i class="fab fa-facebook-f"></i></a>--}}
{{--                        <a href="{{ \App\Helpers::getSettingByKey('twitter_link') }}" class="twitter"><i class="fab fa-twitter"></i></a>--}}
{{--                        <a href="{{ \App\Helpers::getSettingByKey('linkin_link') }}" class="linkedin"><i class="fab fa-linkedin-in"></i></a>--}}
{{--                        <a href="{{ \App\Helpers::getSettingByKey('instagram_link') }}" class="instagram"><i class="fab fa-instagram"></i></a>--}}
{{--                    </div>--}}
                </div>
            </div>
        </section>
    </main>
@endsection
