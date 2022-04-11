@extends('site.layouts.base')
@section('title','Hesabım')
@section('header')
    <style>
        .box-border {
            border: 1px solid #dedede;
            box-shadow: 2px 4px 9px #888888;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection
@section('content')
    <!-- notification modal -->
    <div id="notificationModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

            </div>
        </div>
    </div>
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">Hesabım</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="active">Hesabım</li>
              @include('site.kullanici.partials.addNewServiceButton')
            </ul>
        </div>
    </div>
    <section id="content" class="gray-area">
        <div class="container">
            @include('site.layouts.partials.messages')
            <div id="main">
                <div class="tab-container full-width-style arrow-left dashboard">
                    @include('site.kullanici.partials.myAccountLeftSidebar')
                    <div class="tab-content">
                        <div id="dashboard" class="tab-pane fade in active">
                            <h1 class="no-margin skin-color">Hesabım</h1>
                            <br/>
                            <!-- reservation status cound cards -->

                            <div class="row block">
                                <div class="col-md-9 notifications">
                                    @include('site.kullanici.dashboard.partials.notifications')
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <h4>Rezervasyon Durumu</h4>
                                    </div>
                                    @foreach($reservationCounts as $key => $value)
                                        <div class="col-sm-6 col-md-12">
                                            <a href="{{ route('user.reservations.index',['status' => $value['type']]) }}">
                                                <div
                                                    class="fact {{ __("panel.reservation_status.color.".$value['type']) }}">
                                                    <div class="numbers counters-box">
                                                        <dl>
                                                            <dt>
                                                                {{ $value['count'] }}
                                                            </dt>
                                                            <dd>{{ __("panel.reservation_status.title.".$value['type']) }}</dd>
                                                        </dl>
                                                        <i class="{{ __("panel.reservation_status.icon.".$value['type']) }}"></i>
                                                    </div>
                                                    <div class="description">
                                                        <i class="icon soap-icon-longarrow-right"></i>
                                                        <span>Tümünü Göster</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row flight-list image-box flight listing-style1">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h4 style="margin-bottom: 0px">Son Rezervasyonlar</h4>
                                        <span class="help-block">Onay bekleyen rezervasyonlar</span>
                                    </div>
                                    <div class="col-md-9 pull-right text-right">
                                        <a href="{{ route('user.reservations.index') }}"
                                           class="button btn-mini sky-blue1">Tümünü Gör</a>
                                    </div>
                                </div>
                                @forelse($reservations as $reservation)
                                    <div class="col-sm-6 col-lg-4">
                                        <article class="box box-border">
                                            <figure>
                                                <span><img class="img-service-thumb" alt="" src="{{ imageUrl('public/services/thumb',$reservation->service->image) }}"></span>
                                            </figure>
                                            <div class="details">
                                                <span class="price"><small>Toplam</small>{{ $reservation->total_price }} ₺</span>
                                                <h4 class="box-title">{{ str_limit($reservation->service->title,13) }}
                                                    <small>{{ $reservation->service->type->title }}</small></h4>
                                                <div class="time">
                                                    <div class="take-off">
                                                        <div class="icon"><i
                                                                class="soap-icon-plane-right yellow-color"></i></div>
                                                        <div>
                                                            <span
                                                                class="skin-color">Giriş</span><br/>{{ startedAt($reservation->start_date) }}
                                                        </div>
                                                    </div>
                                                    <div class="landing">
                                                        <div class="icon"><i
                                                                class="soap-icon-plane-right yellow-color"></i></div>
                                                        <div>
                                                            <span
                                                                class="skin-color">Çıkış</span><br/>{{ startedAt($reservation->end_date) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="duration">
                                                    <span class="skin-color">Toplam Süre</span>
                                                    {{ $reservation->day_count }} Gün
                                                    <br>
                                                    <span
                                                        class="skin-color">Durum </span> {{ $reservation->status_text }}
                                                </p>
                                                <div class="action">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <a class="button btn-small"
                                                               href="{{ route('user.reservations.show',['reservation' => $reservation->id]) }}">İncele</a>
                                                        </div>
                                                        @if($reservation->status === \App\Models\Reservation::STATUS_ONAY_BEKLIYOR)
                                                            <div class="col-md-4">
                                                                <form method="POST"
                                                                      action="{{ route('user.reservations.approve',['reservation' => $reservation->id]) }}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                            class="button btn-small green">
                                                                        Onayla
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <form method="POST"
                                                                      action="{{ route('user.reservations.reject',['reservation' => $reservation->id]) }}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                            class="button btn-small  red">
                                                                        İptal Et
                                                                    </button>
                                                                </form>

                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @empty
                                    <p class="h5">Herhangi onay bekleyen rezervasyon bulunmuyor.</p>
                                @endforelse

                            </div>

                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="/js/pages/panel/panel.dashboard.js"></script>
@endsection
