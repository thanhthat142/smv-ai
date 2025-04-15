<footer class="footer">
    <div class="footer-container">
        <div class="footer-left">
            <img src="/frontend/assets/logo2-COvJQh2e.jpg" alt="Mekong Link" class="footer-logo lazyload">
        </div>
        <div class="footer-center">
            <h2>Menu</h2>
            <ul class="menu-list">
                <li><a href="{{ route('frontend.index') }}" class="active">{{ trans('frontend.home') }}</a></li>

                @foreach (\App\Helpers::getCategories() as $cate)
                    <li><a href="{{ route('frontend.cate', $cate->slug) }}">{{ $cate->name }}</a></li>
                @endforeach
                <li><a href="{{ route('frontend.contact') }}">{{ trans('frontend.contact') }}</a></li>
            </ul>
        </div>
        @if ($latestPosts = \App\Helpers::getLatestPosts())
            <div class="footer-right">
                <h2>{{ trans('frontend.latest_post') ?? 'Tin mới nhất' }}</h2>
                <ul class="news-list">
                    @foreach ($latestPosts as $latestPost)
                        <li><a href="{{ route('frontend.post', $latestPost->slug) }}">{{ $latestPost->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="footer-bottom">
        <p>{{ trans('frontend.copy_right') ?? 'Copyright © 2025 Expert consultant All Rights Reserved' }}</p>
    </div>
</footer>
<div class="search-overlay">
    <button class="close-search">
        <i class="fas fa-times"></i>
    </button>
    <div class="search-box">
        <input type="text" id="search-input" placeholder="{{ trans('frontend.search_holder') ?? 'Nhập từ khoá cần tìm kiếm' }}..." class="search-input">
        <button id="search-button" class="button-search">
            <i class="fas fa-search"></i>
        </button>
    </div>
</div>
<button class="btn-goTop">
    <i class="fas fa-arrow-up"></i>
</button>

@section('after_scripts')
    <script>
        $(function (){
            $('#search-button').click(function (){
                window.location.href = '{{ url('search?q=') }}' +  encodeURI($('#search-input').val());
                return false;
            });
        })
    </script>
@endsection
