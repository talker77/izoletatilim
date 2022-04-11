@extends('site.layouts.base')
@section('title',$site->title)
@section('header')
    <title>{{ $item->title }}</title>
    <link rel="stylesheet" href="site/modules/jquery-pagination/dist/bs-pagination.min.css">
    <style>
        .carousel-control.right {
            background-image: linear-gradient(to right,rgba(0,0,0,.0001) 0,rgb(0 0 0 / 9%) 100%)
        }
        .carousel-inner > .item > img {
            min-width: 100%;
            width: 100%;
            max-height: 550px;
        }
    </style>
@endsection
@php
$format = "d-m-Y";
@endphp
@section('content')
    <input type="hidden" id="serviceID" value="{{ $item->id }}">
    <input type="hidden" id="hdnReservationStatus" value="1">
    <div id="page-wrapper">
        <div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">{{ $item->title }}</h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="/">Anasayfa</a></li>
                    <li class="active">{{ $item->title }}</li>
                </ul>
            </div>
        </div>
        <section id="content">
            <div class="container">
                @include('site.layouts.partials.messages')
                <div class="row">
                    <div id="main" class="col-md-9">
                        <div class="tab-container style1" id="hotel-main-content">
                            <div class="tab-content">
                                <!-- gallery -->
                                <div class="">
                                    <div id="main_area">
                                        <!-- Slider -->
                                        <div class="row">
                                            <div class="col-xs-12" id="slider">
                                                <!-- Top part of the slider -->
                                                <div class="row">
                                                    <div class="col-sm-12" id="carousel-bounding-box">
                                                        <div class="carousel slide" id="myCarousel">
                                                            <!-- Carousel items -->
                                                            <div class="carousel-inner">
                                                                <div class="item active" data-slide-number="0">
                                                                    <img src="/storage/services/{{ $item->image }}" >
                                                                </div>
                                                                @foreach($item->images as $image)
                                                                    <div class="item" data-slide-number="{{ $loop->index + 1 }}">
                                                                        <img src="/storage/service-gallery/{{ $image->title }}" >
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <!-- Carousel nav -->
                                                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                                            </a>
                                                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                                            </a>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                        <!--/Slider-->

                                        <div class="row hidden-xs" id="slider-thumbs">
                                            <!-- Bottom switcher of slider -->
                                            <ul class="hide-bullets">
                                                <li class="col-sm-2">
                                                    <a class="thumbnail" id="carousel-selector-0">
                                                        <img src="/storage/services/{{ $item->image }}" style="width: 119px;height: 73px">
                                                    </a>
                                                </li>
                                                @foreach($item->images as $image)
                                                    <li class="col-sm-2">
                                                        <a class="thumbnail" id="carousel-selector-{{ $loop->index + 1 }}">
                                                            <img src="/storage/service-gallery/{{ $image->title }}" style="width: 119px;height: 73px">
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./ gallery -->
                            </div>
                        </div>

                        <div id="hotel-features" class="tab-container">
                            <ul class="tabs">
                                <li class="active"><a href="#hotel-description" data-toggle="tab">Açıklama</a></li>
                                <li><a href="#hotel-amenities" data-toggle="tab">Özellikler</a></li>
                                <li><a href="#hotel-reviews" data-toggle="tab">Yorumlar</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="hotel-description">
                                    <div class="long-description">
                                        {!! $item->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="hotel-amenities">
                                    <ul class="amenities clearfix style2">
                                        @foreach($item->attributes as $attribute)
                                            <li class="col-md-4 col-sm-6">
                                                <div class="icon-box style2"><i
                                                        class="{{ $attribute->icon }}"></i>{{ $attribute->title }}</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="hotel-reviews">
                                    <div class="guest-reviews">

                                        @if(loggedPanelUser())
                                            <form class="review-form" method="POST" action="{{ route('services.add-comment',['serviceId' => $item->id]) }}">
                                                @csrf
                                                <div class="form-group">
                                                    <h4 class="title">Yorumun</h4>
                                                    <textarea class="input-text full-width" placeholder="yorumunuzu buraya girebilirsiniz max:255 karakter" rows="5" maxlength="255" required name="message"></textarea>
                                                </div>
                                                <div class="form-group col-md-5 no-float no-padding no-margin">
                                                    <button type="submit" class="btn-large full-width">Yorum Ekle</button>
                                                </div>
                                            </form>
                                        @endif
                                        <br>
                                        <h2>Kullanıcı Yorumları</h2>
                                        @foreach($item->last_active_comments as $comment)
                                            <div class="guest-review table-wrapper">
                                                <div class="col-xs-3 col-md-2 author table-cell">
                                                    <a href="#"><img src="/site/images/user.png" alt=""
                                                                     width="270" height="263"/></a>
                                                    <p class="name">{{ $comment->user ? $comment->user->full_name : '' }}</p>
                                                    <p class="date">{{ createdAt($comment->created_at) }}</p>
                                                </div>
                                                <div class="col-xs-9 col-md-10 table-cell comment-container">
                                                    <div class="comment-header clearfix">
                                                        <h4 class="comment-title">{{ substr($comment->message,0,10) }}
                                                            ..</h4>
                                                        <div class="review-score">
                                                            <div class="five-stars-container">
                                                                <div class="five-stars"
                                                                     style="width: {{ $comment->point * 10 }}%;"></div>
                                                            </div>
                                                            <span class="score">{{ $comment->point }}/10</span>
                                                        </div>
                                                    </div>
                                                    <div class="comment-content">
                                                        <p>{{ $comment->message }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{--                                    <a href="#" class="button full-width btn-large">LOAD MORE REVIEWS</a>--}}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="sidebar col-md-3">
                        <article class="detailed-logo">

                            <div class="details">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h2 class="box-title">{{ $item->title }}<small><i
                                                    class="soap-icon-departure yellow-color"></i><span
                                                    class="fourty-space">{{ $item->state->title }}, {{ $item->country->title }}</span></small>
                                        </h2>
                                    </div>
                                    <div class="col-md-3">
                                        <img width="45" height="45" src="/site/images/user.png"
                                             title="{{ $item->user->full_name }}"
                                             alt="İlan sahibi {{ $item->user->full_name }}" style="padding-top: 10px">
                                    </div>
                                </div>

                                <div class="feedback clearfix">
                                    <div title="{{ $item->point }}/10" class="five-stars-container"
                                         data-toggle="tooltip" data-placement="bottom">
                                        <span class="five-stars"
                                              style="width: {{ $item->point * 10 }}%;"></span>({{ $item->active_comments_count }}
                                        )
                                    </div>
                                    <span class="review pull-right"><a title="Favorilere Ekle"
                                                                       href="javascript:addToFavorites({{ $item->id }})"><i
                                                class="soap-icon-heart circle" style="font-size: 13px"></i></a></span>
                                </div>
                                <p class="description">{{ implode(" · ",$item->attributes->pluck('title')->toArray()) }}</p>
                                <p class="mile"><span class="skin-color">{{ $item->type->title }} Sahibi:</span> {{ $item->user->full_name }} </p>
                                @if($item->user->phone_visible)
                                    <p class="mile"><span class="skin-color">Telefon:</span> {{ $item->user->phone }} </p>
                                @endif
                            </div>
                        </article>
                        <div class="travelo-box pb-0" id="date-filter">
                            <div class="alert alert-danger-cs" id="reservationMessageBox" style="display: none">
                            </div>
                            <form action="{{ route('services.make-reservation',['serviceId' => $item->id]) }}"
                                  method="POST"
                                  onsubmit="return document.getElementById('hdnReservationStatus') == 0 ? false : confirm('seçtiğiniz tarihler arasında rezervasyon almak istediğinize emin misiniz ?')">
                                @csrf
                                <h5><span class="price-text">{{ $appointment? $appointment->price : '-' }} </span> ₺ /
                                    gece</h5>
                                <div class="row">
                                    <div class="col-xs-12" id="sandbox-container">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="input-group date">
                                                    <input type="text" id="startDate" name="startDate" class="form-control" autocomplete="off" placeholder="Giriş"
                                                           readonly
                                                           value="{{ request('startDate')
                                                        ? \Carbon\Carbon::createFromDate(request()->startDate)->format($format)
                                                        : (!$appointment ?: $appointment->start_date->format($format))  }}"
                                                    >
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12" style="margin-top: 5px">
                                            <div class="row">
                                                <div class="input-group date">
                                                    <input type="text" id="endDate" name="endDate" class="form-control" autocomplete="off" placeholder="Çıkış"
                                                           readonly
                                                           value="{{ \Carbon\Carbon::createFromDate(
                                                            request()->endDate ? : now()->addDay()->toString()
                                                        )->format($format) }}"
                                                    >
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12  mt-9 mb-9">
                                        <button data-animation-duration="1" data-animation-type="bounce"
                                                class="full-width animated" type="submit" id="reservationBtn">Rezervasyon Talebi
                                        </button>
                                        <a class="full-width btn btn-success mt-9"
                                           href="{{ route('user.chat.index',['service' => $item->id]) }}"
                                           type="submit"><i class="fa fa-comment"></i> İlan Sahibiyle İletişime Geç </a>
                                    </div>
                                    <div class="booking-details travelo-box pb-0 {{ ($appointment && $appointment->price) ? '' : 'hidden' }}" id="priceContainer">
                                        <h4>Detay</h4>
                                        <dl class="other-details">
                                            <dt class="feature"><span
                                                    id="perDayPrice">{{ $appointment? $appointment->price : '-' }} </span>
                                                ₺ x <span id="dayCount">{{ $days }}</span> gece:
                                            </dt>
                                            <dd class="value"><span id="totalDayPrice">{{ $totalPrice }}</span> ₺</dd>
                                            <dt class="total-price">Toplam</dt>
                                            <dd class="total-price-value">{{ $totalPrice }} ₺</dd>
                                        </dl>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (count($similarServices))
                            <div class="travelo-box">
                                <h4>Benzer İlanlar</h4>
                                <div class="image-box style14">
                                    @foreach($similarServices as $similar)
                                        <article class="box">
                                            <figure>
                                                <a href="{{ route('services.detail',['slug' => $similar->slug]) }}?startDate={{ request('startDate') }}&endDate={{ request('endDate') }}"><img
                                                        src="/storage/services/{{ $similar->image }}" alt="" width="63"
                                                        height="50" class="similar-img"/></a>
                                            </figure>
                                            <div class="details">
                                                <h5 class="box-title"><a
                                                        href="{{ route('services.detail',['slug' => $similar->slug]) }}">{{ $similar->title }}</a>
                                                </h5>
                                                <label class="price-wrapper">
                                                    {{ $similar->district ? $similar->district->title : '' }}
                                                    /{{ $item->state->title }}
                                                </label>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('footer')
    {{--    <script src="/site/modules/pagination.js"></script>--}}

    <script src="/js/pages/app.services.js"></script>
    <script src="/js/pages/app.services.detail.js"></script>

@endsection
