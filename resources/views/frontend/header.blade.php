<header class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{ route('frontend.index') }}">
                <img src="{{ \App\Helpers::getSettingFileByKey('website_logo') }}" alt="{{ \App\Helpers::getSettingByKey('website_name') }}" class="lazyload">
            </a>
        </div>
        <nav class="nav">
            <ul class="nav-list">
                <li><a href="{{ route('frontend.index') }}" class="{{ request()->routeIs('frontend.index') ? 'active' : '' }}">{{ trans('frontend.home') }}</a></li>
                {{-- <li><a href="{{ route('frontend.chatbot') }}" class="{{ request()->routeIs('frontend.chatbot') ? 'active' : '' }}">{{ trans('frontend.chatbot') }}</a></li> --}}

                @foreach (\App\Helpers::getCategories() as $cate)
                    @if ($cate->children()->count() > 0)
                        <li class="has-submenu">
                            <a href="javascript:void(0)">{{ $cate->name }}</a>
                            <ul class="dropdown-menu">
                                @foreach ($cate->children as $childCate)
                                    @if ($childCate->children()->count() > 0)
                                        <li class="menu-item nav-item has-submenu">
                                            <a href="javascript:void(0)" class="nav-link">{{ $childCate->name }}</a>
                                            <ul class="dropdown-menu">
                                                @foreach ($childCate->children as $childCateLevel2)
                                                    <li class="menu-item nav-item"><a href="{{ route('frontend.cate', $childCateLevel2->slug) }}" class="nav-link">{{ $childCateLevel2->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li class="menu-item nav-item">
                                            <a href="{{ route('frontend.cate', $childCate->slug) }}" class="nav-link">{{ $childCate->name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('frontend.cate', $cate->slug) }}">{{ $cate->name }}</a></li>
                    @endif
                @endforeach
                <li><a href="{{ route('frontend.register_package') }}" class="{{ request()->routeIs('frontend.register_package') ? 'active' : '' }}">{{ trans('frontend.register_package') }}</a></li>
                <li><a href="{{ route('frontend.contact') }}" class="{{ request()->routeIs('frontend.contact') ? 'active' : '' }}">{{ trans('frontend.contact') }}</a></li>
            </ul>
        </nav>
        <div class="right-header">
            <div class="language-select">
                <a href="{{ route('frontend.set-lang', 'vi') }}" class="lang-item {{ App::getLocale() == 'vi' ? "active" : ""}}">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAMAAABBPP0LAAAATlBMVEX+AAD2AADvAQH/eXn+cXL9amr8YmL9Wlr8UlL7TkvoAAD8d0f6Pz/3ODf2Ly/0KSf6R0f6wTv60T31IBz6+jr4+Cv3QybzEhL4bizhAADgATv8AAAAW0lEQVR4AQXBgU3DQBRAMb+7jwKVUPefkQEQTYJqByBENpKUGoZslXoN5LPONH8G9WWZ7pGlOn6XZmaGRce1J/seei4dl+7dPWDqkk7+58e3+igdlySPcYbwBG+lPhCjrtt9EgAAAABJRU5ErkJggg==" alt="{{ trans('frontend.vietnamese_lang') }}" class="lazyload">
                </a>
                <a href="{{ route('frontend.set-lang', 'lo') }}" class="lang-item {{ App::getLocale() == 'lo' ? "active" : ""}}">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAMAAABBPP0LAAAAdVBMVEX9AAD3AADxAADqAAD+eHj8bGz6X1/4UFBsAk3BkLKxd6CkZJOfW42aUoaWS34dAAAAFbyCnuJvjNtjhNnQ2PBJcM89Zs1Ye9UAAIjt8Pf5+fnl6fMxXcknVsbK1O1LADyOSoOGPHuAMXIAAAD0Pj7yLi7dAACHPBxNAAAAWklEQVR4AQXBsXXCUBRAMd3vh+GkSUFNxf6TsQEQO1JAEMpARHy7FRLpb+ZWci7HJjWIa3pn/1hkzjiPfXdY4HLSIhbG8Z75XoX5fZXu+hHbVhfhQVALwRP4B83LD80lYhurAAAAAElFTkSuQmCC" alt="{{ trans('frontend.lao_lang') }}" class="lazyload">
                </a>
                <a href="{{ route('frontend.set-lang', 'end') }}" class="lang-item {{ App::getLocale() == 'en' ? "active" : ""}}">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAMAAABBPP0LAAAAmVBMVEViZsViZMJiYrf9gnL8eWrlYkjgYkjZYkj8/PujwPybvPz4+PetraBEgfo+fvo3efkydfkqcvj8Y2T8UlL8Q0P8MzP9k4Hz8/Lu7u4DdPj9/VrKysI9fPoDc/EAZ7z7IiLHYkjp6ekCcOTk5OIASbfY/v21takAJrT5Dg6sYkjc3Nn94t2RkYD+y8KeYkjs/v7l5fz0dF22YkjWvcOLAAAAgElEQVR4AR2KNULFQBgGZ5J13KGGKvc/Cw1uPe62eb9+Jr1EUBFHSgxxjP2Eca6AfUSfVlUfBvm1Ui1bqafctqMndNkXpb01h5TLx4b6TIXgwOCHfjv+/Pz+5vPRw7txGWT2h6yO0/GaYltIp5PT1dEpLNPL/SdWjYjAAZtvRPgHJX4Xio+DSrkAAAAASUVORK5CYII=" alt="{{ trans('frontend.en_lang') }}" class="lazyload">
                </a>
            </div>
            <button class="search-btn">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACMAAAAfCAYAAABtYXSPAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAEnQAABJ0Ad5mH3gAAAJwSURBVFhH7Za/a9tAFMf7zwg8aNOkoRBNNRgiPNRkMRjqKZ5iPCVDjBcvxaMXo07uUFMIpGBQJ3XSErQYFwoyGDQUNARuKGgQfHNKnn/FOunkBhNKP3DLO+vd555O5/cGr4h/QCZiCGYO7Km9Hu4vhiim+QMpJBMtbfQbBlRFgZI2ShrMzhjePT1QEDmZOIR9XRZLPB8lHc2RB0aPy5IvE/uwztStxVQYjT7Gro8wDGkEmE8ttKva1u8U6FdOIaEcGQano28WeHcJexnRXDrszkJT3wiZI59m8smUCb/UNyJVC77sAWUO2mshA4MZxXMQy8Quuhol1Nqwix6AhQWzRM/XJwgpnIVQJpq2aGcKap9lUu3j9VavmFfnJwUzEMo4V7QrpYXbPxQsypJXhzZkfgooKEYgE8A6JRl+VvLTiPA2r7rjUEyMQGaOwYl8EjFbm7qwKSZGIONjWHlhmcMrw5NUKUllyNUOJLbRTnIkg1+AeQgP8Pyj8ZREqWH8m4JFcbvQSKb1LfuyTBDK4G6TSO95FCwCw+05VUXyixTL8GtqfLZKZmK4oLAk7Ht7vRnt2qVoNhkynNkABiVU9CYmkkKMv57y6vYt8apI3t7ZMhx/ZFJ1ksTUGoj+o6Jgv9U47cN7KRm+Aheq7S6gGqhf9GHdUKd3Y6F/bkJbVeP5qA6khCRknnhsDd6mLJQy1EoX9mKOyYet9kNCSFrmkZhh/nWA1nttv+vjLWe5cQnrR8BrSfDGbFeI31kZX3gxmR0isFWnd5+xQgGhv5ApwJ5QeqN2HJmELaFyz03tjY8nk5AIjcRN+nFlcvgvI+IVyQAPwwVDcxgk+2MAAAAASUVORK5CYII=" alt="{{ trans('frontend.search') }}" class="lazyload">
            </button>
        </div>
        <!-- Thêm nút menu toggle vào header -->
        <button class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
