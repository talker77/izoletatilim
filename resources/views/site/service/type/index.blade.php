@extends('site.layouts.base')
@section('title',$item->title)
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
    <link rel="stylesheet" href="/js/modules/jquery-ui/jquery-ui.min.css"/>
    <style type="text/css">
        .hover-form:hover {
            background-color: #e5f2f6;
            box-shadow: 0 10px 20px 0 rgb(41 51 57 / 15%), 0 3px 6px 0 rgb(41 51 57 / 10%);
        }

        .hover-form1:hover {
            background-color: #e5f2f6;
            box-shadow: 0 10px 20px 0 rgb(41 51 57 / 15%), 0 3px 6px 0 rgb(41 51 57 / 10%);
            border-radius: 10px;
        }


        .formrow {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 20px 0 rgb(41 51 57 / 15%), 0 3px 6px 0 rgb(41 51 57 / 10%);
            padding-top: 10px;
        }

        .hover-effect {
            border-top-right-radius: 12px;
            border-top-left-radius: 12px;
        }

        .stl0 {
            margin-bottom: 0px !important;
        }

        .box {
            border-radius: 12px;
            box-shadow: 0 10px 20px 0 rgb(41 51 57 / 15%), 0 3px 6px 0 rgb(41 51 57 / 10%) !important
        }

        .box img {
            border-top-right-radius: 12px;
            border-top-left-radius: 12px;
            padding: 0px
        }

        .action a {
            background: #428500
        }

        .price {
            font-size: 24px;
            color: #3792c7;
            font-weight: 700;
        }
    </style>
@endsection
@section('content')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">{{ $item->title }}</h2></div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="active">{{ $item->title }}</li>
            </ul>
        </div>
    </div>

    <section id="content" class="no-padding">
        <div class="banner imagebg-container"
             style="height: 350px; background-image: url(/site/images/service/type/{{ __("lang.service_types.".Request::route("serviceType.slug").".banner_image") }}); background-size: cover; background-position:center">
            <div class="container">
                <h1 class="big-caption">{{ __("lang.service_types.".Request::route("serviceType.slug").".title") }}</h1>
                <h2 class="med-caption med-caption-bg yellow-color">{!! __("lang.service_types.".Request::route("serviceType.slug").".sub_title")  !!}</h2>
            </div>
        </div>
        <div class="tab-wrapper" style="background: whitesmoke;">
            <div class="tab-container container trans-style">
                <form action="{{ route('services') }}" method="GET">
                    <input type="hidden" name="country" id="hdnCountry">
                    <input type="hidden" name="state" id="hdnState">
                    <input type="hidden" name="district" id="hdnDistrict">
                    <input name="type" type="hidden" value="{{ $item->id }}"/>
                    <div class="row formrow" style="">
                        <div class="form-group col-sm-6 col-md-4  stl0">
                            <label>Konum</label>
                            <input type="text" class="input-text full-width" id="villaSearch" name="query"
                                   placeholder="Şehir , ilçe veya bölge giriniz"/>
                            <label> &nbsp;</label>
                        </div>
                        <div class="form-group col-sm-9 col-md-6 stl0 ">
                            <div class="row">
                                <div class="col-xs-4 ">
                                    <label> Giriş &nbsp;</label>
                                    <div >
                                        <input type="date" name="startDate" class="input-text full-width" required
                                               min="{{ now()->format('Y-m-d') }}"
                                               placeholder="Giriş"/></div>
                                    <label> &nbsp;</label>
                                </div>
                                <div class="col-xs-4">
                                    <label> Çıkış&nbsp;</label>
                                    <div>
                                        <input type="date" name="endDate" class="input-text full-width" required
                                               min="{{ date('Y-m-d',strtotime('+1 day')) }}"
                                               placeholder="Çıkış"/></div>
                                    <label> &nbsp;</label>
                                </div>
                                <div class="col-xs-4">
                                    <label for="">Kişi</label>
                                    <div class="input-group number-spinner">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" data-dir="dwn"><span
                                                    class="glyphicon glyphicon-minus"></span></button>
                                        </span>
                                        <input type="text" class="form-control text-center" value="1" name="person">
                                        <span class="input-group-btn">
                                            <button  type="button" class="btn btn-default" data-dir="up"><span
                                                    class="glyphicon glyphicon-plus"></span></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-3 col-md-2  fixheight mb-sm-4">
                            <label> &nbsp;</label>
                            <button type="submit" class="full-width">Ara</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="section container">
            <h2>{{ __("lang.service_types.".Request::route("serviceType.slug").".popular_locations") }}</h2>
            <div class="row image-box hotel listing-style1">
                @foreach($data['popular'] as $popular)
                    <div class="col-sms-6 col-sm-6 col-md-3">
                        <article class="box">
                            <figure class="animated" data-animation-type="fadeInDown" data-animation-delay="0">
                                <a class=" stl14  "
                                   href="{{ route('services.detail',['slug' => $popular->slug]) }}" title="">
                                    <img width="270" height="160"
                                         class="img-service-thumb"
                                         src="{{ imageUrl('public/services/thumb',$popular->image) }}"
                                         alt="{{ $popular->title }}"></a>
                            </figure>
                            <div class="details">
                                <span class="price">
                                    <small>Fiyat/Gece</small>
                                    {{ round($popular->avg_price) }} ₺
                                </span>
                                <h4 class="box-title">
                                    <a href="{{ route('services.detail',['slug' => $popular->slug]) }}"
                                       title="{{ $popular->title }}">
                                        {{ $popular->roundedTitle(16) }}<small>{{ $popular->location_text }}</small>
                                    </a>
                                </h4>
                                <div class="feedback">
                                    <div title="{{ $popular->point }}/10" class="five-stars-container"
                                         data-toggle="tooltip"
                                         data-placement="bottom"><span class="five-stars"
                                                                       style="width: {{ $popular->star_percent }}%;"></span>
                                    </div>
                                    <span class="review">{{ $popular->active_comments_count }} Yorum</span>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="parallax global-map-area" data-stellar-background-ratio="0.1"
             style="background-position: 50% -157.767px; background: url(/site/images/service/type/parallax/parallax-1.png); background-position: center">
            <div class="promo-box" style="    margin: 0 0 0px 0;">
                <div class="container">
                    <div class="content-section description pull-right col-sm-9" style="height: 236px;">
                        <div class="table-wrapper hidden-table-sm" style="height: 100%;">
                            <div class="table-cell">
                                <div class="animated fadeInDown" data-animation-type="fadeInDown"
                                     data-animation-duration="1.5" data-animation-delay="0"
                                     style="animation-duration: 1.5s; visibility: visible;">
                                    <div>
                                        <h2 class="m-title">{!!  __("lang.service_types.".Request::route("serviceType.slug").".parallax_text")  !!}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="image-container col-sm-3 " style="height: 236px; position: relative; margin-left: -5%;">
                        <img
                            src="/site/images/service/type/section-left.png"
                            alt="promo box image1" width="342" height="258" class="animated fadeInUp"
                            data-animation-type="fadeInUp"
                            data-animation-duration="" data-animation-delay=""
                            style="position: absolute; bottom: 0px; left: 0px; animation-duration: 1s; visibility: visible;">
                    </div>
                </div>
            </div>
        </div>
        <div class="container section">
            <h2>Yeni Eklenenler</h2>
            <div class="block image-carousel style2 flexslider" data-animation="slide" data-item-width="270"
                 data-item-margin="30">
                <ul class="slides image-box style1">
                    @foreach($data['last'] as $last)
                        <li>
                            <article class="box">
                                <figure>
                                    <a
                                       href="{{ route('services.detail',['slug' => $last->slug]) }}">
                                        <img width="270" height="160" alt="{{ $last->title }}"
                                             class="img-service-thumb"
                                             src="{{ imageUrl('public/services/thumb',$last->image) }}">
                                    </a>
                                </figure>
                                <div class="details">
                                    <span class="price"><small>En Düşük</small>{{ round($last->service_appointments->min('price')) }} ₺</span>
                                    <a href="{{ route('services.detail',['slug' => $last->slug]) }}">
                                        <h4 class="box-title">{{ $last->roundedTitle(13) }}<small>Gece</small></h4>
                                    </a>
                                </div>
                            </article>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="container">
            <div class="section">
                <h2>En Çok Favoriye Eklenenler</h2>
                <div class="flexslider image-carousel style2 row-2" data-animation="slide" data-item-width="370"
                     data-item-margin="30">
                    <ul class="slides image-box style11">
                        @foreach($data['favorites']->chunk(2) as $favorites)
                            <li>
                                @foreach($favorites as $favorite)
                                    <article class="box">
                                        <figure>
                                            <a title=""
                                               href="{{ route('services.detail',['slug' => $favorite->service->slug]) }}">
                                                <img width="370" height="160" alt=""
                                                     src="{{ imageUrl('public/services/thumb',$favorite->service->image) }}"></a>
                                            <figcaption>
                                                <h3 class="caption-title">{{ $favorite->service->title }}</h3>
                                                <span>{{ $favorite->service->location_text }}</span>
                                            </figcaption>
                                        </figure>
                                    </article>
                                @endforeach
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>

        <div class="offers section">
            <div class="container">
                @if(is_array(__("lang.service_types.".Request::route("serviceType.slug").".seo")))
                    @foreach(__("lang.service_types.".Request::route("serviceType.slug").".seo") as $seo)
                        <div class="col-md-6">
                            <h3 style="font-weight: 700">{{ $seo['title'] }}</h3>
                            <p>{!! $seo['description'] !!}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection
