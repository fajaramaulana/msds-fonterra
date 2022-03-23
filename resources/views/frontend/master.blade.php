<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#FFFFFF">
    <title>
        FBMI MSDS
    </title>
    <meta name="Author" content="Fajar Agus Maulana">
    <meta name="author" content="Fajar Agus Maulana">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/frontend/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/base.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css')}}">
    <script src="{{ asset('frontend/js/modernizr.js')}}"></script>
    <script src="{{ asset('frontend/js/pace.min.js')}}"></script>
</head>
<body id="top">
    @include('frontend.navigation')
    @yield('content')
    @include('frontend.footer')
    <div aria-hidden="true" class="pswp" role="dialog" tabindex="-1">

        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">

            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div><button class="pswp__button pswp__button--close"
                        title="Close (Esc)"></button> <button class="pswp__button pswp__button--share"
                        title="Share"></button> <button class="pswp__button pswp__button--fs"
                        title="Toggle fullscreen"></button> <button class="pswp__button pswp__button--zoom"
                        title="Zoom in/out"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div><button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>

        </div>

    </div>
    <div id="preloader">
        <div id="loader"></div>
    </div>
    <script src="{{ asset('frontend/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('frontend/js/plugins.js')}}"></script>
    <script src="{{ asset('frontend/js/main.js')}}"></script>
</body>
</html>
