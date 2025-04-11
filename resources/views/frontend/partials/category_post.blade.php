@if ($posts)
    @foreach ($posts as $post)
        <div class="list-news-item">
            <div class="news-img">
                <img src="{{ \App\Helpers::getImageUrlBySize($post, 347, 240) }}" alt="{{ $post->name }}" class="lazyload">
            </div>
            <div class="news-content">
                <a href="{{ route('frontend.post', $post->slug) }}" class="news-title">{{ $post->name }}</a>
                <div class="news-meta">{{ $post->created_at->format('d/m/Y') }}</div>
                <div class="news-desc">
                    <p>{{ $post->desc }}</p>
                </div>
                <a href="{{ route('frontend.post', $post->slug) }}" class="btn-detail">{{ trans('frontend.detail') }}</a>
            </div>
        </div>
    @endforeach
@endif
