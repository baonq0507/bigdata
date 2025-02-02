<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign in</title>
    <link href="{{ asset('vendor/future/dist/css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/future/dist/css/tabler-flags.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/future/dist/css/tabler-payments.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/future/dist/css/tabler-vendors.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/future/dist/css/demo.min.css') }}" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>
<body class=" d-flex flex-column">
<script src="{{asset('dist/js/demo-theme.min.js')}}"></script>
<div class="page page-center">
    @yield('content')
</div>
@vite('resources/js/app.js')
<script src="{{ asset('vendor/future/dist/js/tabler.min.js') }}" defer></script>
<script src="{{ asset('vendor/future/dist/js/demo.min.js') }}" defer></script>
@include('notifications::swal')
@yield('script')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>

<script>
    if (!Cookies.get("sidebarState")) {
        Cookies.set("sidebarState", "collapsed", {
            expires: 7,
            sameSite: 'Lax'
        });
    }
</script>


@livewireScripts
</body>
</html>
