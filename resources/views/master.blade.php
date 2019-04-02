<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Firdows Marble</title>
    <link rel="stylesheet" href="/frameworks/bootstrap.min.css">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/frameworks/ionicons.min.css">
    <script src="/frameworks/jquery1.js"></script>
    <script src="/frameworks/bootstrap.min.js"></script>
    <script src="/js/base.js"></script>
</head>
<body>

    @include("header")

    @yield("content")

    @include("errors")

</body>
</html>