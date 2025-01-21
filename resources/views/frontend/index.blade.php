@extends('frontend.layout')

@section('content')
    @include('frontend.slider')
    <main>
        <section class="services block">
            <div class="container">
                <h2 class="block-title">Dịch Vụ Của Chúng Tôi</h2>
                <p class="block-desc">
                    Chúng tôi cung cấp một loạt các dịch vụ chính dưới đây.<br>
                    Vui lòng nhấp vào một dịch vụ cụ thể để biết thêm về dịch vụ đó.
                </p>
                <div class="services-grid">
                    <!-- Dịch thuật -->
                    <a href="#" class="service-item" title="Dịch thuật">
                        <div class="service-title">
                            <h3>Dịch Thuật</h3>
                        </div>
                        <div class="background-overlay"></div>
                        <div class="service-img">
                            <img src="/frontend/assets/dv-img-1-CmmEhbaN.jpeg" alt="" class="lazyload">
                        </div>
                    </a>

                    <!-- Phiên âm -->
                    <a href="#" class="service-item" title="Phiên âm">
                        <div class="service-title">
                            <h3>Phiên Âm</h3>
                        </div>
                        <div class="background-overlay"></div>
                        <div class="service-img">
                            <img src="/frontend/assets/dv-img-2-wJcwpFDK.jpeg" alt="" class="lazyload">
                        </div>
                    </a>

                    <!-- Phụ đề -->
                    <a href="#" class="service-item" title="Phụ đề">
                        <div class="service-title">
                            <h3>Phụ đề</h3>
                        </div>
                        <div class="background-overlay"></div>
                        <div class="service-img">
                            <img src="/frontend/assets/dv-img-3-CkQ_GN3g.jpeg" alt="" class="lazyload">
                        </div>
                    </a>

                    <!-- Lồng tiếng -->
                    <a href="#" class="service-item" title="Lồng tiếng">
                        <div class="service-title">
                            <h3>Lồng tiếng</h3>
                        </div>
                        <div class="background-overlay"></div>
                        <div class="service-img">
                            <img src="/frontend/assets/dv-img-4-BmqCnKHi.jpeg" alt="" class="lazyload">
                        </div>
                    </a>

                    <!-- Phiên dịch -->
                    <a href="#" class="service-item" title="Phiên dịch">
                        <div class="service-title">
                            <h3>Phiên Dịch</h3>
                        </div>
                        <div class="background-overlay"></div>
                        <div class="service-img">
                            <img src="/frontend/assets/dv-img-5-Djo4qqeG.jpeg" alt="" class="lazyload">
                        </div>
                    </a>

                    <!-- Biên tập -->
                    <a href="#" class="service-item" title="Biên tập">
                        <div class="service-title">
                            <h3>Biên tập</h3>
                        </div>
                        <div class="background-overlay"></div>
                        <div class="service-img">
                            <img src="/frontend/assets/dv-img-6-BE8upnOo.jpeg" alt="" class="lazyload">
                        </div>
                    </a>
                </div>
            </div>
        </section>
        <section class="hot-news block">
            <div class="container">
                <h2 class="block-title">Nổi bật</h2>
                <div class="hot-news-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide hot-news-item">
                            <a href="#" class="hot-news-img" title="Bản tin kinh tế Đại sứ quán Việt Nam tại Lào tháng 10/2024">
                                <img src="/frontend/assets/nb-img-1-kTP6_QMg.jpg" alt="Nổi bật 1" class="lazyload">
                            </a>
                            <div class="hot-news-detail">
                                <a href="#" class="hot-new-title">Bản tin kinh tế Đại sứ quán Việt Nam tại Lào tháng 10/2024 Việt Nam tại Lào tháng 10/2024</a>
                                <div class="hot-new-desc">
                                    <p>
                                        Dự án hợp tác phát triển nông thôn toàn diện là bước tiến mới trong hợp tác giữa hai nước là bước tiến mới trong hợp tác giữa hai nước
                                    </p>
                                </div>
                                <a href="#" class="hot-new-readmore">Xem thêm</a>
                            </div>
                        </div>
                        <div class="swiper-slide hot-news-item">
                            <a href="#" class="hot-news-img" title="Bản tin kinh tế Đại sứ quán Việt Nam tại Lào tháng 10/2024">
                                <img src="/frontend/assets/nb-img-2-C5I3DIfM.jpg" alt="Nổi bật 1" class="lazyload">
                            </a>
                            <div class="hot-news-detail">
                                <a href="#" class="hot-new-title">Bản tin kinh tế Đại sứ quán Việt Nam tại Lào tháng 10/2024</a>
                                <div class="hot-new-desc">
                                    <p>
                                        Dự án hợp tác phát triển nông thôn toàn diện là bước tiến mới trong hợp tác giữa hai nước
                                    </p>
                                </div>
                                <a href="#" class="hot-new-readmore">Xem thêm</a>
                            </div>
                        </div>
                        <div class="swiper-slide hot-news-item">
                            <a href="#" class="hot-news-img" title="Bản tin kinh tế Đại sứ quán Việt Nam tại Lào tháng 10/2024">
                                <img src="/frontend/assets/nb-img-3-REej8QJX.jpg" alt="Nổi bật 1" class="lazyload">
                            </a>
                            <div class="hot-news-detail">
                                <a href="#" class="hot-new-title">Bản tin kinh tế Đại sứ quán Việt Nam tại Lào tháng 10/2024</a>
                                <div class="hot-new-desc">
                                    <p>
                                        Dự án hợp tác phát triển nông thôn toàn diện là bước tiến mới trong hợp tác giữa hai nước
                                    </p>
                                </div>
                                <a href="#" class="hot-new-readmore">Xem thêm</a>
                            </div>
                        </div>
                        <div class="swiper-slide hot-news-item">
                            <a href="#" class="hot-news-img" title="Bản tin kinh tế Đại sứ quán Việt Nam tại Lào tháng 10/2024">
                                <img src="/frontend/assets/nb-img-1-kTP6_QMg.jpg" alt="Nổi bật 1" class="lazyload">
                            </a>
                            <div class="hot-news-detail">
                                <a href="#" class="hot-new-title">Bản tin kinh tế Đại sứ quán Việt Nam tại Lào tháng 10/2024</a>
                                <div class="hot-new-desc">
                                    <p>
                                        Dự án hợp tác phát triển nông thôn toàn diện là bước tiến mới trong hợp tác giữa hai nước
                                    </p>
                                </div>
                                <a href="#" class="hot-new-readmore">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                    <div class="btn-next-prev">
                        <div class="hot-news-next"></div>
                        <div class="hot-news-prev"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="categories block">
            <div class="container">
                <h2 class="block-title">Chuyên Mục</h2>
                <div class="categories-tabs">
                    <button class="tab-btn active" data-tab="law">Tin Tức Pháp Luật</button>
                    <button class="tab-btn" data-tab="reference">Tham Khảo</button>
                    <button class="tab-btn" data-tab="investment">Tài Liệu Đầu Tư</button>
                    <button class="tab-btn more-btn" onclick="window.location.href='/news-list.html'">+</button>
                </div>

                <div class="categories-content">
                    <!-- Tab Pháp luật -->
                    <div class="tab-content active" id="law">
                        <div class="news-grid">
                            <!-- Tin chính bên trái -->
                            <div class="news-main">
                                <div class="news-img">
                                    <img src="/frontend/assets/dv-img-1-CmmEhbaN.jpeg" alt="News" class="lazyload">
                                </div>
                                <a href="#" class="news-title">Lao động Myanmar tại Lào và những lưu ý đối với doanh nghiệp
                                    Lao động Myanmar tại Lào và những lưu ý đối với doanh nghiệp
                                    Lao động Myanmar tại Lào và những lưu ý đối với doanh nghiệp
                                </a>
                                <div class="news-meta">07/12/2024</div>
                                <div class="news-desc">
                                    <p>Theo thống kê chưa đầy đủ, hiện nay có gần 50.000 lao động Myanmar đang làm việc tại Lào
                                        Theo thống kê chưa đầy đủ, hiện nay có gần 50.000 lao động Myanmar đang làm việc tại Lào
                                        Theo thống kê chưa đầy đủ, hiện nay có gần 50.000 lao động Myanmar đang làm việc tại Lào
                                    </p>
                                </div>
                                <a href="#" class="btn-detail">Chi tiết</a>
                            </div>

                            <!-- Danh sách tin nhỏ bên phải -->
                            <div class="news-list">
                                <!-- Tin 1 -->
                                <div class="news-item">
                                    <div class="news-img">
                                        <img src="/frontend/assets/dv-img-2-wJcwpFDK.jpeg" alt="News" class="lazyload">
                                    </div>
                                    <div class="news-content">
                                        <a href="#" class="news-title">Bản tin kinh tế Đại sứ quán Việt Nam tại Lào tháng 10/2024
                                            Theo thống kê chưa đầy đủ, hiện nay có gần 50.000 lao động Myanmar đang làm việc tại Lào
                                            Theo thống kê chưa đầy đủ, hiện nay có gần 50.000 lao động Myanmar đang làm việc tại Lào
                                            Theo thống kê chưa đầy đủ, hiện nay có gần 50.000 lao động Myanmar đang làm việc tại Lào
                                        </a>
                                        <div class="news-meta">18/11/2024</div>
                                    </div>
                                </div>

                                <!-- Tin 2 -->
                                <div class="news-item">
                                    <div class="news-img">
                                        <img src="/frontend/assets/dv-img-3-CkQ_GN3g.jpeg" alt="News" class="lazyload">
                                    </div>
                                    <div class="news-content">
                                        <a href="#" class="news-title">Tuần san Doanh nghiệp số 28</a>
                                        <div class="news-meta">09/10/2024</div>
                                    </div>
                                </div>

                                <!-- Tin 3 -->
                                <div class="news-item">
                                    <div class="news-img">
                                        <img src="/frontend/assets/dv-img-4-BmqCnKHi.jpeg" alt="News" class="lazyload">
                                    </div>
                                    <div class="news-content">
                                        <a href="#" class="news-title">Tuần san Doanh nghiệp số 27</a>
                                        <div class="news-meta">02/10/2024</div>
                                    </div>
                                </div>

                                <!-- Tin 4 -->
                                <div class="news-item">
                                    <div class="news-img">
                                        <img src="/frontend/assets/dv-img-5-Djo4qqeG.jpeg" alt="News" class="lazyload">
                                    </div>
                                    <div class="news-content">
                                        <a href="#" class="news-title">Tuần san Doanh nghiệp số 26</a>
                                        <div class="news-meta">25/09/2024</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Tham khảo -->
                    <div class="tab-content" id="reference">
                        <!-- Tương tự như trên -->
                    </div>

                    <!-- Tab Đầu tư -->
                    <div class="tab-content" id="investment">
                        <!-- Tương tự như trên -->
                    </div>
                </div>
            </div>
        </section>
        <section class="contact-section">
            <div class="container">
                <div class="contact-info">
                    <div class="info-box">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Ta-134/A, Gulshan Badda<br>Link Rd Dhaka</p>
                    </div>
                    <div class="info-box">
                        <i class="fas fa-volume-control-phone"></i>
                        <p><a href="tel:+8807620813">(+880) 762 0813</a>
                            <br> <a href="tel:+7850985648">(+785) 098 5648</a></p>
                    </div>
                    <div class="info-box">
                        <i class="fas fa-envelope"></i>
                        <p>
                            <a href="mailto:info@yourmail.com">info@yourmail.com</a>
                            <br>
                            <a href="mailto:info@exe.com">info@exe.com</a>
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
                    <form>
                        <input type="text" placeholder="Họ và tên">
                        <input type="email" placeholder="Email">
                        <input type="tel" placeholder="Số điện thoại">
                        <textarea placeholder="Tôi muốn tư vấn về"></textarea>
                        <button type="submit">Gửi đi</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
