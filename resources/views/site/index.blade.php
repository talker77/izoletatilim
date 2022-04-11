@extends('site.layouts.base')
@section('title',$site->title)
@section('header')

    <title>{{ $site->title }}</title>
    <meta name="description" content="{{ $site->spot }}"/>
    <meta name="keywords" content="{{ $site->keywords }}"/>
    <meta property="og:type" content="website "/>
    <meta property="og:url" content="{{ $site->domain }}"/>
    <meta property="og:title" content="{{ $site->title }}"/>
    <meta property="og:image" content="{{ $site->domain.'/img/logo.png'}}"/>
    <meta name="twitter:card" content="website"/>
    <meta name="twitter:site" content="@siteadi"/>
    <meta name="twitter:creator" content="@siteadi"/>
    <meta name="twitter:title" content="{{ $site->title }}"/>
    <meta name="twitter:description" content="{{ $site->spot }}"/>
    <meta name="twitter:image:src" content="{{ $site->domain.'/img/logo.png'}}"/>
    <meta name="twitter:domain" content="{{$site->domain}}"/>
    <link rel="canonical" href="{{ $site->domain }}"/>
    <style>
        .base-header {
            display: none;
        }
    </style>
@endsection
@section('content')
    <header id="" class="navbar-static-top" style="display: block!important;">
        <div class="main-header">
            <div class="container">
                <h1 class="logo navbar-brand">
                    <a href="/" title="{{ $site->title }}"></a>
                </h1>
                <nav id="main-menu" role="navigation">
                    <ul class="menu" style="float:left;">
                        @foreach($types as $type)
                            <li class="menu-item-has-children" style="">
                                <a href="{{ route('services.types.index',['serviceType' => $type->slug]) }}">{{ $type->title }}</a>
                            </li>
                        @endforeach
                        <li class="menu-item">
                            <a class="sp-hire" href="{{ route('locations') }}">Bölgeler</a>
                        </li>
                    </ul>
                    <ul class="menu">
                        @auth('panel')
                            <li>
                                <a href="{{ route('user.dashboard') }}">{{ loggedPanelUser()->full_name }} ({{ loggedPanelUser()->unreadNotifications->count() }})</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('user.login') }}">Üye ol / Giriş</a>
                            </li>
                            <li>
                                <a class="sp-hire"
                                   href="{{ route('user.register',['type' => \App\Models\Auth\Role::ROLE_STORE]) }}">Kiraya
                                    Ver</a>
                            </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="row clearfix" style="margin-bottom: 50px"></div>
    <section id="content">
        <div class="search-box-wrapper">
            <div class="search-box container">
                <div class="search-tab-content" style="">
                    <div class="tab-pane fade active in" id="hotels-tab">
                        <div class="row">
                            <div class="col-md-2" style=";margin-bottom: 15px">
                                <img src="/site/images/logo/logo2.png">
                            </div>
                            <div class="col-md-10" style=";margin-bottom: 15px">
                                <p class="baslik125">Kalabalıktan uzak, izole tatilin keyfini çıkaracağınız villa,
                                    tekne, dağ evi, bungalow ve karavan alternatifleri bir arada!
                                    <br>
                                    <span class="hero__subtitle">Şehir, belirli bir otel veya ünlü bir yer aramayı deneyin!</span>
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('services') }}" method="GET">
                            <input type="hidden" name="country" id="hdnCountry">
                            <input type="hidden" name="state" id="hdnState">
                            <input type="hidden" name="district" id="hdnDistrict">
                            {{--                            <input name="startDate" id="startDate" type="hidden"/>--}}
                            {{--                            <input name="endDate" id="endDate" type="hidden"/>--}}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <label> Konum</label>
                                        <input type="text" class="input-text full-width"
                                               placeholder="Otel adı veya bölge giriniz" name="query" id="villaSearch"/>
                                    </div>
                                    <div class="col-md-2">
                                        <label> Giriş &nbsp;</label>
                                        <div>
                                            <input type="date" name="startDate" id="startDate" class="input-text full-width" required
                                                   min="{{ now()->format('Y-m-d') }}"
                                                   placeholder="Giriş"/></div>
                                        <label> &nbsp;</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label> Çıkış&nbsp;</label>
                                        <div>
                                            <input type="date" name="endDate" id="endDate" class="input-text full-width" required
                                                   min="{{ date('Y-m-d',strtotime('+1 day')) }}"
                                                   placeholder="Çıkış"/></div>
                                        <label> &nbsp;</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Ne Arıyorsun ?</label>
                                        <div>
                                            <select class="full-width form-control" name="type">
                                                @foreach($types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Kişi</label>
                                        <div class="input-group number-spinner">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" data-dir="dwn"><span
                                                    class="glyphicon glyphicon-minus"></span></button>
                                        </span>
                                            <input type="text" class="form-control text-center" value="1" name="person">
                                            <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" data-dir="up"><span
                                                    class="glyphicon glyphicon-plus"></span></button>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-0 col-md-1">
                                        <label for="">&nbsp;</label>
                                        <button type="submit" class="full-width"
                                                data-animation-type="bounce" data-animation-duration="1">Ara
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-8 our">
                                <h4 style="font-weight: bold">İzole Tatil ile ilgili tüm alternatifleri tek bir
                                    platformda sizlere sunuyoruz.</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Popuplar Destinations -->
        <div class="destinations section" style="padding-bottom: 0px">
            <div class="container">
                <div class="block">
                    <h1>Tatiliniz için yeni fikirlere mi ihtiyacınız var?</h1>
                    <p>TÜRKİYE’NİN HER BÖLGESİNDEN YILIN 4 MEVSİMİ İZOLE TATİL İLE İLGİLİ YAZILARIMIZI KEŞFEDİN.. </p>
                    <div class="row image-box style3">
                        @foreach($locations->take(8) as $location)
                            <div class="col-sm-6 col-md-3">
                                <article class="box">
                                    <figure>
                                        <a href="{{ route('services'). $location->params }}"
                                           title="{{ $location->title }}">
                                            <img src="/storage/locations/{{ $location->image }}"
                                                 alt="{{ $location->title }}" width="270" height="160"/>
                                        </a>
                                    </figure>
                                    <div class="details text-center">
                                        <h4 class="box-title">{{ $location->title }}</h4>
                                        <p class="offers-content">{{ $location->district ? $location->district->title : '' }}
                                            ,{{ $location->state->title }}</p>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- teb -->
        <div class="destinations section" style="background: white;">
            <div class="container">
                <div class="col-md-12">
                    <div class="tab-container style1">
                        <ul class="tabs">
                            <h2>İZOLE TATİL ROTALARI TEK TIK UZAĞINIZDA!</h2>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="unlimited-layouts">
                                <div class="block">
                                    <div class="image-carousel style3 flex-slider" data-item-width="170"
                                         data-item-margin="30">
                                        <ul class="slides image-box style9">
                                            @foreach($local_services as $local_service)
                                                <li>
                                                    <div class="col-sms-12">
                                                        <a href="{{ route('services.detail',['slug' => $local_service->slug]) }}">
                                                            <article class="box">
                                                                <figure class="animated fadeInDown"
                                                                        data-animation-type="fadeInDown"
                                                                        data-animation-delay="0"
                                                                        style="animation-duration: 1s; visibility: visible;">
                                                                    <img width="270" height="160"
                                                                         alt="{{ $local_service->title }}"
                                                                         src="/storage/services/thumb/{{  $local_service->image }}">
                                                                </figure>
                                                                <div class="details text-center">
                                                                    <h4 class="box-title">{{ $local_service->title }}</h4>
                                                                    <p class="offers-content">
                                                                        ({{ $local_service->active_comments_count }}
                                                                        yorum)</p>
                                                                    <div data-placement="top" data-toggle="tooltip"
                                                                         title="" class="five-stars-container"
                                                                         data-original-title="{{ $local_service->star }} yıldız">
                                                                        <span
                                                                            style="width: {{ $local_service->star_percent }}%;"
                                                                            class="five-stars"></span>
                                                                    </div>
                                                                </div>
                                                            </article>
                                                        </a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- tab son -->
        <div class="features section global-map-area parallax hidden-xs" data-stellar-background-ratio="0.5"
             style="background: url(http://soaptheme.net/wordpress/travelo/wp-content/uploads/bgimages/global-map-green.jpg); padding-bottom: 0px;height: 100%">
            <div class="container" style="height: 100%">
                <div class="content-section description pull-right col-sm-6" style="height: 532px;">
                    <div class="table-wrapper hidden-table-sm" style="height: 100%;">
                        <div class="table-cell">
                            <div>
                                <h1 class="title">Tatiliniz için yeni fikirlere mi ihtiyacınız var?</h1>
                                <p style="color: white">TÜRKİYE’NİN HER BÖLGESİNDEN YILIN 4 MEVSİMİ İZOLE TATİL İLE
                                    İLGİLİ YAZILARIMIZI KEŞFEDİN.. </p>
                            </div>
                            <div class="tour-packages row add-clearfix image-box listing-style2">
                                @foreach($locations->skip(8)->take(4) as $location)
                                    <div class="col-sm-6 col-md-6">
                                        <article class="box" style="height: auto; min-height: 99px;">
                                            <figure>
                                                <a href="{{ route('services'). $location->params }}">
                                                    <img width="500" height="300"
                                                         src="/storage/locations/{{ $location->image }}"
                                                         class="attachment-biggallery-thumb size-biggallery-thumb wp-post-image"
                                                         alt=""></a>
                                                <figcaption>
                                                    <h2 class="caption-title">{{ $location->title }}</h2>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image-container col-md-6 hidden-xs "
                     style="height: 532px; position: relative; margin-left: -5%;"><img
                        src="http://www.soaptheme.net/wordpress/travelo/wp-content/uploads/bgimages/women.png"
                        alt="woman" width="540" height="517" class="animated fadeInUp"
                        data-animation-type="fadeInUp" data-animation-duration="2" data-animation-delay=""
                        style="position: absolute; bottom: 0px; left: 0px; animation-duration: 2s; visibility: visible;">
                </div>
            </div>
        </div>
        <div class="offers section">
            <div class="container">
                <div class="col-md-6">
                    <h3 style="font-weight: 700">Tatil deyince aklınıza ne geliyor?</h3>
                    <p>Tatil deyince aklınıza ne geliyor? Bu sorunun cevabı, herkes için değişiyor. Kimileri için tatil deniz-kum-güneş üçlüsünden ibaretken, kimileri yeni yerler görmek ve yeni kültürleri tanımak istiyor. Kimi zaman da, adrenalin dolu
                        etkinlikler en ideal tatil yerine geçiyor. Tatilin tanımı ve kapsamı kişiden kişiye değişse de, hep aynı kalan bir şey var: tatil, herkesin ihtiyacı. İster iş hayatının stresini geride bırakmaya çalışın, isterseniz de bir dünya gezgini
                        olun, her yıl belli bir dönemi tatil yapmaya ayırmanız gerekiyor. İzoletatilim, bu doğrultuda sizlere tatilinizi kendiniz belirleyeceğiniz seçenekler sunuyor. </p>
                </div>
                <div class="col-md-6">
                    <p>Yurt içi tatiliniz için yazın vazgeçilmez rotaları arasında yer alan Ege ve Akdeniz sahillerine uzanabilir; Çeşme, Bodrum, Fethiye ve Antalya’nın daha birçok tatil yerlerini sayfamızdan bulabilirsiniz. Enfes kumsallarından berrak
                        sularına doğru bir yolculuğa çıkabilirsiniz. Temiz havaya doymak ve yeşilin binbir tonuna şahit olmak için Karadeniz turları ile doğa tatili yapabilir, günübirlik veya hafta sonu turları ile hayata kısa bir mola verebilir, tatiliniz
                        kendiniz belirleyebilirsiniz. <br> <br>

                        Tercih sizden, popüler tatil yerleri İzoletatilim'den...
                        İzoletatilim ile seyahat planınızı sorunsuz bir şekilde gerçekleştirebilirsiniz.</p>
                </div>
            </div>
        </div>
        <!-- Features section -->

    </section>
@endsection
@section('footer')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css"/>
    {{--    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>--}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <script>
        $(document).ready(function () {
            $("#startDate").val(moment().format('YYYY-MM-DD'))
            $("#endDate").val(moment().add(1, 'days').format('YYYY-MM-DD'))
        });
        $('#daterange').daterangepicker({
            autoApply: true,
            minDate: moment().format("MM/DD/YYYY"),
            endDate: moment().add(1, 'days').format("MM/DD/YYYY"),
            alwaysShowCalendars: true,
        }, function (start, end, label) {
            console.log(start)
            $("#startDate").val(start.format('YYYY-MM-DD'));
            $("#endDate").val(end.format('YYYY-MM-DD'));
        });
    </script>
@endsection
