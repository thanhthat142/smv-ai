<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ trans('frontend.home') }}</title>
    <link rel="stylesheet" href="/frontend/css/all.min.css">
    <script type="module" crossorigin src="/frontend/assets/main-Cx57V1_U.js"></script>
    <link rel="stylesheet" crossorigin href="/frontend/assets/main-DWiscHl-.css">
</head>
<body>
<div id="app">
    @include('frontend.header')
    @yield('content')
    @include('frontend.footer')
</div>
</body>
</html>
