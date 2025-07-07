@extends('frontend.layout')

@section('content')
    <div class="container">
        <style>
            .register-wrapper {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: flex-start;
                gap: 40px;
                margin-top: 40px;
                padding-bottom: 60px;
            }

            .form-section {
                flex: 1;
                min-width: 320px;
                max-width: 550px;
            }

            .image-section {
                flex: 1;
                min-width: 320px;
                text-align: center;
            }

            .image-section img {
                width: 100%;
                max-width: 500px;
                height: auto;
                border-radius: 12px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                object-fit: cover;
            }

            .form-section h1 {
                font-size: 28px;
                margin-bottom: 24px;
                color: #222;
            }

            .form-group {
                margin-bottom: 18px;
            }

            .form-group label {
                display: block;
                font-weight: 600;
                margin-bottom: 6px;
            }

            .form-group input,
            .form-group select {
                width: 100%;
                padding: 12px 14px;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 15px;
                box-sizing: border-box;
            }

            button {
                padding: 14px 30px;
                font-size: 16px;
                font-weight: bold;
                background-color: #f44336;
                color: white;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            button:hover {
                background-color: #d32f2f;
            }

            @media (max-width: 768px) {
                .register-wrapper {
                    flex-direction: column;
                    align-items: center;
                }

                .image-section img {
                    max-width: 100%;
                }
            }
        </style>

        <div class="register-wrapper">
            <!-- Form Section -->
            <div class="form-section">
                <h1>{{ trans('frontend.package_form_title') }}</h1>
                <form action="" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="package">{{ trans('frontend.package_select') }}</label>
                        <select name="package" id="package" required>
                            <option value="mobile">{{ trans('frontend.package_option_mobile') }}</option>
                            <option value="sim">{{ trans('frontend.package_option_sim') }}</option>
                            <option value="internet">{{ trans('frontend.package_option_internet') }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ trans('frontend.package_name') }}</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="fullname">{{ trans('frontend.fullname') }}</label>
                        <input type="text" id="fullname" name="fullname" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">{{ trans('frontend.phone') }}</label>
                        <input type="number" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="email">{{ trans('frontend.email') }}</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <button type="submit">{{ trans('frontend.package_submit_btn') }}</button>
                </form>
            </div>

            <!-- Image Section -->
            <div class="image-section">
                <img src="{{ asset('frontend/assets/overview.png') }}" alt="Unitel">
            </div>
        </div>
    </div>
@endsection
