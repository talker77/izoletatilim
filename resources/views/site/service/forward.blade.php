<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>
<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html> <!--<![endif]-->
<head>
    <!-- Page Title -->
    <title>{{ $site->title  }}</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Theme Styles -->
    <link rel="stylesheet" href="/site/css/bootstrap.min.css">
    <link rel="stylesheet" href="/site/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/site/css/animate.min.css">

    <!-- Main Style -->
    <link id="main-style" rel="stylesheet" href="/site/css/style.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="/site/css/custom.css">

    <!-- Responsive Styles -->
    <link rel="stylesheet" href="/site/css/responsive.css">

    <!-- CSS for IE -->
    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css" href="/site/css/ie.css"/>
    <![endif]-->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type='text/javascript' src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
</head>
<body class="post-404page style1">
<div id="page-wrapper">
    <header id="header" class="navbar-static-top">

        <div class="container">

        </div>

    </header>

    <section id="content">
        <div class="container">
            <div id="main">
                <div class="col-md-6 col-sm-9 no-float no-padding center-block">
                    <div class="error-message">
                        <img src="/site/logo.png" style="height: 50px" alt="{{ $site->title }}"/>
                        <img src="/site/other/loading.gif" style="height: 125px ;padding-bottom: 15px" alt="{{ $company->title }} loading gif"/>
                        <img src="/storage/company/{{ $company->image }}" title="{{ $company->image }}"/>
                        <p style="font-size: 30px"><strong>izoletatilim.com</strong>'da uygun bir fiyat buldunuz</p style="font-size: 30px">
                        <p style="font-size: 30px"><strong>{{ $company->title }}</strong> sitesine yönlendiriliyorsunuz</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


</div>

<!-- Javascript -->

<script>
    function getParameterByName(name, url = window.location.href) {
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    setTimeout(function () {
        const redirectTo = getParameterByName('redirectTo')
        if(redirectTo){
           window.location.href = redirectTo
        }
    }, 1300)
</script>
</body>
</html>
