@extends('frontend.layout')

@section('content')
    <main>
        <section class="block contact-page">
            <div class="container">
                <div class="contact-info-grid">
                    <div class="info-item">
                        <div class="icon">
                            <i class="far fa-envelope"></i>
                        </div>
                        <h3>Email</h3>
                        <p><a href="mailto:info@mekonglink.com">info@mekonglink.com</a></p>
                        <p><a href="mailto:info@mekonglink.com">info@mekonglink.com</a></p>
                    </div>

                    <div class="info-item">
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Địa chỉ</h3>
                        <p>Số 377, đường Nongbon, bản Phonxay, quận Xaysettha, thủ đô Viêng Chăn, Lào</p>
                    </div>

                    <div class="info-item">
                        <div class="icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h3>Hotline</h3>
                        <p><a href="tel:+8562095403838">(+856 20) 9540 3838</a></p>
                        <p><a href="tel:+8562076043333">(+856 20) 7604 3333</a></p>
                    </div>
                </div>
                <div class="contact-form-section">
                    <h2 class="section-title">Gửi thông tin liên hệ</h2>
                    <p class="section-desc">Hãy gửi thông tin cho chúng tôi để nhận phản hồi và thắc mắc</p>

                    <form class="contact-form">
                        <div class="form-row">
                            <input type="text" placeholder="Họ & Tên" class="form-input">
                            <input type="email" placeholder="Email" class="form-input">
                        </div>
                        <div class="form-row">
                            <input type="tel" placeholder="Số điện thoại" class="form-input">
                            <input type="text" placeholder="Tiêu đề" class="form-input">
                        </div>
                        <div class="form-row">
                            <select class="form-select">
                                <option value="">Tôi muốn tư vấn về</option>
                                <option value="1">Dịch vụ 1</option>
                                <option value="2">Dịch vụ 2</option>
                                <option value="3">Dịch vụ 3</option>
                            </select>
                        </div>
                        <button type="submit" class="submit-btn">
                            <i class="far fa-paper-plane"></i>
                            Gửi thông tin
                        </button>
                    </form>
                </div>
            </div>
            <div class="gg-map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3794.8293580086607!2d102.61341937507825!3d17.97975708389611!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3124687d8f67dda7%3A0x1f6b9c5f3e1e7d0f!2zQ8O0bmcgVHkgROG7i2NoIFRodeG6rXQgVsOgIEThu4tjaCBW4bulIEjDuW5nIEhldWFuZw!5e0!3m2!1svi!2s!4v1709799611099!5m2!1svi!2s"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </section>
    </main>
@endsection
