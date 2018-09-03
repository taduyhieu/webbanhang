<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{!! "VCCI" !!}</title>
        <meta name="author" content="THC">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <?php $sessionLayout = Session::has('display-layout') ? Session::get('display-layout') : null ?>
        {!! HTML::script('assets/js/jquery.2.0.3.js') !!}
        {!! HTML::style("frontend/css/bootstrap.min.css") !!}
        {!! HTML::style("frontend/css/font-awesome.min.css") !!}
        {!! HTML::style("frontend/css/prettyPhoto.css") !!}
        <!-- {!! HTML::style("frontend/css/home.css") !!} -->
        <!--        <link rel="stylesheet" type="text/css" href="{!!url('frontend/css/home.css')!!}">-->
        @if(!$sessionLayout || $sessionLayout == 'pc')
        {!! HTML::style("frontend/css/baiviet.css") !!}
        {!! HTML::style("frontend/css/home.css") !!}
        {!! HTML::style("frontend/css/thi-truong.css") !!}
        @else
        {!! HTML::style("frontend/css/mobile/baiviet.css") !!}
        {!! HTML::style("frontend/css/mobile/home.css") !!}
        {!! HTML::style("frontend/css/mobile/thi-truong.css") !!}
        @endif

        {!! HTML::style("frontend/css/owl.theme.default.min.css") !!}
        {!! HTML::style("frontend/css/owl.carousel.min.css") !!}
        {!! HTML::style("assets/css/github-right.css") !!}
        {!! HTML::script("frontend/js/popper.min.js") !!}
        {!! HTML::script("frontend/js/bootstrap.min.js") !!}
        {!! HTML::script("frontend/js/jquery.prettyPhoto.js") !!}       
        {!! HTML::script("frontend/js/jquery.min.js") !!}
        {!! HTML::script("frontend/js/owl.carousel.min.js") !!}

        <link rel="shortcut icon" href="{!! url('favicon.ico') !!}">
    </head>
    <body>
        @include('frontend/layout/menu')
        @yield('content')
        @include('frontend/layout/footer')

        <script type="text/javascript">
            /*----------*/
            $(document).ready(function () {
                $('#img-partner').owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: true,
                    autoplay: true,
                    autoplayTimeout: 2000,
                    responsive: {
                        0: {
                            items: 1
                        },
                        500: {
                            items: 2
                        },
                        600: {
                            items: 3
                        },
                        1000: {
                            items: 5
                        },

                    }
                });
            });
            $('#project-slide').owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                autoplay: true,
                autoplayTimeout: 2000,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
        </script>
    </body>
</html>