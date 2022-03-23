<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex" />
    <meta name="googlebot-news" content="noindex" />
    <meta name="googlebot" content="noindex">
    <meta name="googlebot-news" content="nosnippet">
    <meta name="googlebot" content="nosnippet">
    <meta name="googlebot-image" content="noindex">
    <meta name="googlebot" content="noimageindex">
    <meta name="googlebot-video" content="noindex">
    <meta name="googlebot" content="nofollow">
    <meta name="googlebot-news" content="nofollow">
    <meta name="googlebot-image" content="nofollow">
    <meta name="googlebot-video" content="nofollow">
    <meta name="googlebot" content="noodp">
    <meta name="googlebot-news" content="noodp">
    <meta name="googlebot-image" content="noodp">
    <meta name="googlebot-video" content="noodp">
    <meta name="googlebot" content="noydir">
    <meta name="googlebot-news" content="noydir">
    <meta name="googlebot-image" content="noydir">
    <meta name="googlebot-video" content="noydir">
    <meta name="googlebot" content="noarchive">
    <meta name="googlebot-news" content="noarchive">
    <meta name="googlebot-image" content="noarchive">
    <meta name="googlebot-video" content="noarchive">
    <meta name="googlebot" content="noimageindex">
    <meta name="googlebot-news" content="noimageindex">
    <meta name="googlebot-image" content="noimageindex">
    <meta name="googlebot-video" content="noimageindex">
    <meta name="Author" content="Fajar Agus Maulana">
    <meta name="author" content="Fajar Agus Maulana">
    <meta name="googlebot" content="nositepreview">
    <meta name="googlebot-news" content="nositepreview">
    <meta name="googlebot-image" content="nositepreview">
    <meta name="googlebot-video" content="nositepreview">
    <meta name="googlebot" content="nosnippet">
    <meta name="googlebot-news" content="nosnippet">
    <meta name="googlebot-image" content="nosnippet">
    <meta name="googlebot-video" content="nosnippet">
    <meta name="googlebot" content="noarchive">
    <meta name="googlebot-news" content="noarchive">
    <meta name="googlebot-image" content="noarchive">
    <meta name="googlebot-video" content="noarchive">
    <meta name="googlebot" content="noimageindex">
    <meta name="googlebot-news" content="noimageindex">
    <meta name="googlebot-image" content="noimageindex">
    <meta name="googlebot-video" content="noimageindex">
    <title>Fonterra MSDS - @yield('title')</title>
    @include('admin.template-admin.head')
</head>

<body>
    @include('admin.template-admin.navigation')
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('sub-judul')</h1>
            </div>
            <div class="section-body">
                @yield('content')
            </div>
        </section>
    </div>
    @include('admin.template-admin.footer')

</body>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('script')

</html>
