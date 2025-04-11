@extends('frontend.layout')

@section('content')
    <main>
        <section class="block list-news-page">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('frontend.index') }}">{{ trans('frontend.index') }}</a></li>
                    <li><span>{{ $cate->name }}</span></li>
                </ul>
                <div class="list-news-content">
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
                </div>
                <a id="loadMoreCate" href="javascript:void(0)" class="hot-new-readmore">{{ trans('frontend.view_more') }}</a>
            </div>
        </section>
    </main>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            let loadMoreButton = $('#loadMoreCate');
            let start = 9;
            loadMoreButton.click(function(){
                const buttonEle = $(this);
                $.post('{{ route('frontend.load_more_cate') }}', { start : start , cate : '{{$cate->id}}'}, function(res) {
                    if (res.error) {
                        loadMoreButton.hide();
                    } else {
                        start+=9;
                        buttonEle.prev('div').append(res.html);
                    }
                    return false;
                });
            });
        });
    </script>
@endsection

