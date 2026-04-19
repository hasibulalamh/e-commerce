<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Shop | eCommers</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://preview.colorlib.com/theme/capitalshop/assets/img/icon/favicon.png.webp">

    <!-- CSS here -->
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/slicknav.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/flaticon.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/animate.min.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/price_rangs.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/themify-icons.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/slick.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/nice-select.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/capitalshop/assets/css/style.css">
</head>

<body>
    <!--? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/icon/loder.png.webp" alt="loder">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <!-- header Start -->
    @include('frontend.fixed.header')
    <!-- header end -->
    <!-- main c0ntent -->
    @yield('content')
    <!-- main c0ntent -->
    <!-- footer start-->
    @include('frontend.fixed.footer')
    <!-- footer start-->
    <!-- Scroll Up -->
    <div id="back-top">
        <a class="wrapper" title="Go to Top" href="#">
            <div class="arrows-container">
                <div class="arrow arrow-one">
                </div>
                <div class="arrow arrow-two">
                </div>
            </div>
        </a>
    </div>

    <!-- JS here -->
    <!-- Jquery, Popper, Bootstrap -->
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/popper.min.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/bootstrap.min.js"></script>

    <!-- Slick-slider , Owl-Carousel ,slick-nav -->
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/owl.carousel.min.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/slick.min.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/jquery.slicknav.min.js"></script>

    <!--wow , counter , waypoint, Nice-select -->
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/wow.min.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/jquery.magnific-popup.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/jquery.nice-select.min.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/jquery.counterup.min.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/waypoints.min.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/price_rangs.js"></script>

    <!-- contact js -->
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/contact.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/jquery.form.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/jquery.validate.min.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/mail-script.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/jquery.ajaxchimp.min.js"></script>

    <!--  Plugins, main-Jquery -->
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/plugins.js"></script>
    <script src="https://preview.colorlib.com/theme/capitalshop/assets/js/main.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>

    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"936eb526dcf2d4ed","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"version":"2025.4.0-1-g37f21b1","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
    @stack('js')
</body>

</html>