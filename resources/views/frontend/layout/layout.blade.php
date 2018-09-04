<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{!! "SHOP" !!}</title>
        <meta name="author" content="THC">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <?php $sessionLayout = Session::has('display-layout') ? Session::get('display-layout') : null ?>

          
        <link rel="icon" type="image/png" href="images/icons/favicon.png"/>
        {!! HTML::style("frontend/vendor/bootstrap/css/bootstrap.min.css") !!}  
        {!! HTML::style("frontend/fonts/font-awesome-4.7.0/css/font-awesome.min.css") !!} 
        {!! HTML::style("frontend/fonts/themify/themify-icons.css") !!}  
        {!! HTML::style("frontend/fonts/Linearicons-Free-v1.0.0/icon-font.min.css") !!} 
        {!! HTML::style("frontend/fonts/elegant-font/html-css/style.css") !!}  
        {!! HTML::style("frontend/vendor/animate/animate.css") !!}  
        {!! HTML::style("frontend/vendor/css-hamburgers/hamburgers.min.css") !!}
        {!! HTML::style("frontend/vendor/animsition/css/animsition.min.css") !!}
        {!! HTML::style("frontend/vendor/select2/select2.min.css") !!}
        {!! HTML::style("frontend/vendor/daterangepicker/daterangepicker.css") !!}
        {!! HTML::style("frontend/vendor/slick/slick.css") !!}
        {!! HTML::style("frontend/vendor/lightbox2/css/lightbox.min.css") !!}
        {!! HTML::style("frontend/css/util.css") !!}
        {!! HTML::style("frontend/css/main.css") !!}

        <link rel="shortcut icon" href="{!! url('favicon.ico') !!}">
    </head>
    <body class="animsition">
        @include('frontend/layout/menu')
        @yield('content')
        @include('frontend/layout/footer')
        {!! HTML::script("frontend/vendor/jquery/jquery-3.2.1.min.js") !!}
        {!! HTML::script("frontend/vendor/animsition/js/animsition.min.js") !!}
        {!! HTML::script("frontend/vendor/bootstrap/js/popper.js") !!}
        {!! HTML::script("frontend/vendor/bootstrap/js/bootstrap.min.js") !!}
        {!! HTML::script("frontend/vendor/select2/select2.min.js") !!}
        <script type="text/javascript">
            $(".selection-1").select2({
                minimumResultsForSearch: 20,
                dropdownParent: $('#dropDownSelect1')
            });
        </script>
        {!! HTML::script("frontend/vendor/slick/slick.min.js") !!}
        {!! HTML::script("frontend/js/slick-custom.js") !!}
        {!! HTML::script("frontend/vendor/countdowntime/countdowntime.js") !!}
        {!! HTML::script("frontend/vendor/lightbox2/js/lightbox.min.js") !!}
        {!! HTML::script("frontend/vendor/sweetalert/sweetalert.min.js") !!}
        <script type="text/javascript">
            $('.block2-btn-addcart').each(function(){
                var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
                $(this).on('click', function(){
                    swal(nameProduct, "is added to cart !", "success");
                });
            });

            $('.block2-btn-addwishlist').each(function(){
                var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
                $(this).on('click', function(){
                    swal(nameProduct, "is added to wishlist !", "success");
                });
            });
        </script>
        {!! HTML::script("frontend/js/main.js") !!}
    </body>
</html>