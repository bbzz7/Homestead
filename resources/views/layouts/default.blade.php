<!DOCTYPE html>
<html>
<head>
    <title>@yield('title','Weibo App')- Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
@include('layouts._header')
<div id="app" class="container">
    <div class="col-md-offset-1 col-md-10">
        @include('shared._messages')
        @yield('content')
    </div>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1">
        @include('layouts._footer')
    </div>
</div>
<script src="/js/app.js"></script>
</body>
</html>