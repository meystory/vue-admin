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

    <!-- Scripts -->
    <!-- <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script> -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        window.auth = {!! $auth !!};

        window.permissions = {!! $permissions !!};

        window.menuTree = {!! $menuTree !!}
    </script>
</head>
<body>

    <div id="app"></div>
    <!-- Scripts -->
    <script src="{{ mix('js/main.js') }}"></script>
    <script src="{{ mix('js/all.js') }}"></script>
    <script src="{{ asset('js/toastr/toastr.min.js') }}"></script>
</body>
</html>
