<!DOCTYPE html>
<html dir="{{ locale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ locale() == 'ar' ? 'ar' : 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }} || {{ config('app.name') }} </title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">
    <meta name="author" content="{{ config('setting.app_name.' . locale()) ?? '' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Font Icons -->
    <link rel="stylesheet" href="{{ url('frontend/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/themify-icons.css') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ url('frontend/css/bootstrap.min.css') }}">

    <!-- Template style -->
    @if (locale() == 'ar')
        <link rel="stylesheet" href="{{ url('frontend/css/style-ar.css') }}">
    @else
        <link rel="stylesheet" href="{{ url('frontend/css/style-en.css') }}">
    @endif

    <link rel="icon"
        href="{{ config('setting.favicon') ? url(config('setting.favicon')) : url('frontend/favicon.png') }}" />

</head>

<body>
    <div class="main-content">

        <div class="site-main">
            <div class="container">
                <div class="inner-page">
                    <div class="single-page">
                        <h1>{{ $page->title }}</h1>
                        {!! $page->description !!}
                    </div>

                </div>
            </div>
        </div>

    </div>

</body>

</html>
