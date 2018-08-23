<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('js/toastr/toastr.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery/jquery-3.3.1.min.js') }}"></script>
    @yield('css')

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<!-- 登录页面单独，不使用Vue -->
<body class="page-body login-page">
    <div id="app">
        @yield('content')
    </div>

    <!-- Scripts -->
    
    <script src="{{ mix('js/all.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript">
        
    </script>
    @yield('js')
</body>
</html>
