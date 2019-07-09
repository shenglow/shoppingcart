<!DOCTYPE html>
<html>
<!-- Head BEGIN -->
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta content="Shopping Cart" name="description">
    <meta content="Shopping Cart" name="keywords">
    <meta content="boon" name="author">

    <meta property="og:site_name" content="Shopping Cart">
    <meta property="og:title" content="Shopping Cart">
    <meta property="og:description" content="Shopping Cart">
    <meta property="og:type" content="website">
    <meta property="og:image" content="-CUSTOMER VALUE-"><!-- link to image for socio -->
    <meta property="og:url" content="-CUSTOMER VALUE-">

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Fonts START -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css">
    <!--- fonts for slider on the index page -->
    <!-- Fonts END -->

    <!-- Global styles START -->
    <link href="{{ asset('front/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Global styles END -->

    <!-- Page level plugin styles START -->
    <link href="{{ asset('front/pages/css/animate.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/plugins/owl.carousel/assets/owl.carousel.css') }}" rel="stylesheet" type="text/css">
    <!-- Page level plugin styles END -->

    <!-- Theme styles START -->
    <link href="{{ asset('front/pages/css/components.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/pages/css/slider.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/pages/css/style-shop.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/corporate/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/corporate/css/style-responsive.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/corporate/css/themes/red.css') }}" rel="stylesheet" type="text/css" id="style-color">
    <link href="{{ asset('front/corporate/css/custom.css') }}" rel="stylesheet" type="text/css">
    <!-- Theme styles END -->
</head>
<!-- Head END -->

<!-- Body BEGIN -->
<body class="ecommerce">

    @include('front/layouts/header')

    @yield('content')

    @include('front/layouts/footer')
  
    <!-- Load javascripts at bottom, this will reduce page load time -->
    <!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
    <script src="{{ asset('front/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('front/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('front/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('front/corporate/scripts/back-to-top.js') }}" type="text/javascript"></script>
    <script src="{{ asset('front/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="{{ asset('front/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script><!-- pop up -->
    <script src="{{ asset('front/plugins/owl.carousel/owl.carousel.min.js') }}" type="text/javascript"></script>
    <!-- slider for products -->
    <script src="{{ asset('front/plugins/zoom/jquery.zoom.min.js') }}" type="text/javascript"></script><!-- product zoom -->
    <script src="{{ asset('front/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}" type="text/javascript"></script>
    <!-- Quantity -->

    <script src="{{ asset('front/corporate/scripts/layout.js') }}" type="text/javascript"></script>
    <script src="{{ asset('front/pages/scripts/bs-carousel.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            Layout.init();
            Layout.initOWL();
            Layout.initImageZoom();
            Layout.initTouchspin();
            Layout.initTwitter();
        });
    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>