<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>{{ trans('frontend.home') }}</title>
    <script type="module" crossorigin src="/frontend/assets/main-Cx57V1_U.js"></script>
    <link rel="stylesheet" crossorigin href="/frontend/assets/main-DWiscHl-.css">
    <link rel="icon" type="image/png" href="{{ asset('frontend/assets/favicon.png') }}">
    {!! \App\Helpers::getSettingByKey('analytics_code') !!}
    {!! \App\Helpers::getSettingByKey('webmaster_code') !!}
</head>
<body>
<div id="app">
    {{-- @include('frontend.header') --}}
    @yield('content')
    {{-- @include('frontend.footer') --}}
    @yield('chatbot')
</div>
</body>
<script type="text/javascript" src="/frontend/js/jquery-2.2.4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@yield('after_scripts')
</html>
