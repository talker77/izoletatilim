<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>
<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html> <!--<![endif]-->
<head>
    <meta name="robots" content="noindex">
    <meta charset=utf-8>
    <meta name="googlebot" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Theme Styles -->
    <link rel="stylesheet" href="/site/css/bootstrap.min.css">
    <link rel="stylesheet" href="/site/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/site/css/animate.min.css">

    <!-- Current Page Styles -->
    <link rel="stylesheet" type="text/css" href="/site/components/revolution_slider/css/settings.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/site/components/revolution_slider/css/style.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/site/components/jquery.bxslider/jquery.bxslider.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/site/components/flexslider/flexslider.css" media="screen"/>

    <!-- Main Style -->
    <link id="main-style" rel="stylesheet" href="/site/css/style.css">

    <!-- Updated Styles -->
    <link rel="stylesheet" href="/site/css/updates.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="/site/css/custom.css">

    <!-- Responsive Styles -->
    <link rel="stylesheet" href="/site/css/responsive.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="/site/modules/toastr/toastr.min.css">

    <!-- CSS for IE -->
    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css" href="/site/css/ie.css"/>
    <![endif]-->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type='text/javascript' src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->

    <!-- Javascript Page Loader -->
    <script type="text/javascript" src="/site/js/pace.min.js" data-pace-options='{ "ajax": false }'></script>
    <script type="text/javascript" src="/site/js/page-loading.js"></script>

    <!-- datetimepicker -->
    <link rel="stylesheet" type="text/css" href="/site/modules/timepicker/v4/bootstrap-datepicker.min.css"/>
    @yield('header')
</head>
<body>


<div id="page-wrapper">
    @include('site.layouts.partials.header')
    @yield('content')
    @include('site.layouts.partials.footer')
</div>


</body>
<!-- Javascript -->
{{--<script src="/site/vendor/jquery.min.js"></script>--}}
{{--<script type="text/javascript" src="/site/js/jquery-2.0.2.min.js"></script>--}}
<script src="/site/js/jquery.min.js"></script>
<script type="text/javascript" src="/site/js/jquery.noconflict.js"></script>
<script type="text/javascript" src="/site/js/modernizr.2.7.1.min.js"></script>
<script type="text/javascript" src="/site/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/site/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="/site/js/jquery-ui.1.10.4.min.js"></script>

<!-- Twitter Bootstrap -->
<script type="text/javascript" src="/site/js/bootstrap.min.js"></script>

<!-- load revolution slider scripts -->
<script type="text/javascript" src="/site/components/revolution_slider/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="/site/components/revolution_slider/js/jquery.themepunch.revolution.min.js"></script>

<!-- load BXSlider scripts -->
<script type="text/javascript" src="/site/components/jquery.bxslider/jquery.bxslider.min.js"></script>

<!-- Flex Slider -->
<script type="text/javascript" src="/site/components/flexslider/jquery.flexslider.js"></script>

<!-- parallax -->
<script type="text/javascript" src="/site/js/jquery.stellar.min.js"></script>

<!-- parallax -->
<script type="text/javascript" src="/site/js/jquery.stellar.min.js"></script>

<!-- waypoint -->
<script type="text/javascript" src="/site/js/waypoints.min.js"></script>

<!-- load page Javascript -->
<script type="text/javascript" src="/site/js/theme-scripts.js"></script>
<script type="text/javascript" src="/site/js/scripts.js"></script>
<script type="text/javascript" src="/site/modules/toastr/toastr.min.js"></script>




<script type="text/javascript">
    var $=jQuery.noConflict();
    tjq(document).ready(function () {
        tjq('.revolution-slider').revolution(
            {
                sliderType: "standard",
                sliderLayout: "auto",
                dottedOverlay: "none",
                delay: 9000,
                navigation: {
                    keyboardNavigation: "off",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation: "off",
                    mouseScrollReverse: "default",
                    onHoverStop: "on",
                    touch: {
                        touchenabled: "on",
                        swipe_threshold: 75,
                        swipe_min_touches: 1,
                        swipe_direction: "horizontal",
                        drag_block_vertical: false
                    }
                    ,
                    arrows: {
                        style: "default",
                        enable: true,
                        hide_onmobile: false,
                        hide_onleave: false,
                        tmp: '',
                        left: {
                            h_align: "left",
                            v_align: "center",
                            h_offset: 20,
                            v_offset: 0
                        },
                        right: {
                            h_align: "right",
                            v_align: "center",
                            h_offset: 20,
                            v_offset: 0
                        }
                    }
                },
                visibilityLevels: [1240, 1024, 778, 480],
                gridwidth: 1170,
                gridheight: 646,
                lazyType: "none",
                shadow: 0,
                spinner: "spinner4",
                stopLoop: "off",
                stopAfterLoops: -1,
                stopAtSlide: -1,
                shuffle: "off",
                autoHeight: "off",
                hideThumbsOnMobile: "off",
                hideSliderAtLimit: 0,
                hideCaptionAtLimit: 0,
                hideAllCaptionAtLilmit: 0,
                debugMode: false,
                fallbacks: {
                    simplifyAll: "off",
                    nextSlideOnWindowFocus: "off",
                    disableFocusListener: false,
                }
            });
    });
</script>

<script type="text/javascript" src="/site/js/custom.js"></script>

<!-- datetimepicker -->
<script type="text/javascript" src="/site/modules/timepicker/v4/bootstrap-datepicker.min.js"></script>

@yield('footer')
</html>
