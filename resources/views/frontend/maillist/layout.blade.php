<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="THC">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {!! HTML::script('assets/js/jquery.2.0.3.js') !!}
    {!! HTML::style("frontend/css/bootstrap.min.css") !!}
    {!! HTML::style("frontend/css/font-awesome.min.css") !!}
</head>
<body>
@yield('content')
{!! HTML::script("frontend/js/bootstrap.min.js") !!}
{!! HTML::script("frontend/js/jquery.prettyPhoto.js") !!}
{!! HTML::script("frontend/js/main.js") !!}
</body>
</html>
