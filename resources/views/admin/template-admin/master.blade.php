<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
