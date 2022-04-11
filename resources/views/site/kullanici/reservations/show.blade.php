@extends('site.layouts.base')
@section('title','İlan Detay')
@section('header')
    <!-- Select2 -->
    <link rel="stylesheet" href="/site/modules/select2/dist/css/select2.min.css">
    <style>
        #serviceBlock a {
            margin-right: 4px;
        }
    </style>
    <link rel="stylesheet" href="/admin_files/plugins/jquery-datatable/jquery.dataTables.min.css">

@endsection

@section('content')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">@lang('panel.navbar.services')</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li><a href="{{ route('user.services.index') }}">@lang('panel.navbar.reservations')</a></li>
                <li class="active">{{ $item->title }}</li>
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
                        <div id="main" class="col-sms-6 col-sm-8 col-md-12">
                            <div class="booking-section travelo-box">
                                <div class="container">
                                    <div class="row">
                                        <div id="main" class="col-sm-8 col-md-9">
                                            <div class="booking-information travelo-box">
                                                <h2>Rezervasyon Durumu</h2>
                                                <hr/>
                                                <div class="booking-confirmation clearfix">
                                                    <i class="{{ __("panel.reservation_status.icon.".$item->status)  ?: 'soap-icon-recommend icon' }} circle"></i>
                                                    <div class="message">
                                                        <h4 class="main-message">{{ __("panel.reservation_status.title.".$item->status) }}</h4>
                                                        <p>{{ __("panel.reservation_status.".loggedPanelUser()->role_id.".description.".$item->status) }}</p>
                                                    </div>
                                                    @if($item->status === \App\Models\Reservation::STATUS_ONAY_BEKLIYOR and loggedPanelUser()->isStore())
                                                        <form method="POST"
                                                              action="{{ route('user.reservations.approve',['reservation' => $item->id]) }}">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="button btn-small print-button green uppercase mb-9">
                                                                Onayla
                                                            </button>
                                                        </form>
                                                        <form method="POST"
                                                              action="{{ route('user.reservations.reject',['reservation' => $item->id]) }}"
                                                              class="mt-4">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="button btn-small print-button red uppercase">
                                                                İptal ET
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if(loggedPanelUser()->isCustomer() and in_array($item->status,[\App\Models\Reservation::STATUS_ONAY_BEKLIYOR,\App\Models\Reservation::STATUS_EMAIL_ONAY_BEKLIYOR]))
                                                        <form method="POST"
                                                              action="{{ route('user.reservations.cancel',['reservation' => $item->id]) }}"
                                                              class="mt-4">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="button btn-small print-button red uppercase">
                                                                İptal ET
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                                <hr/>
                                                <h2>Rezervasyon Bilgileri</h2>
                                                <dl class="term-description">
                                                    <dt>Rezervasyon ID :</dt>
                                                    <dd>{{ $item->id }}</dd>
                                                    <dt>@lang('panel.service'):</dt>
                                                    <dd>
                                                        <a href="{{ loggedPanelUser()->isCustomer() ? route('services.detail',['slug' => $item->service->slug]) : route('user.services.edit',['service' => $item->service_id]) }}">
                                                            <i class="fa fa-external-link"></i> {{ $item->service->title }}
                                                        </a>
                                                    </dd>
                                                    <dt>Giriş :</dt>
                                                    <dd>{{ startedAt($item->start_date) }}</dd>
                                                    <dt>Çıkış :</dt>
                                                    <dd>{{ startedAt($item->end_date) }}</dd>
                                                    <dt>Fiyat (Gün) :</dt>
                                                    <dd>{{ $item->price }} ₺</dd>
                                                    <dt>Gün</dt>
                                                    <dd>{{ $item->day_count }} Gün
                                                    </dd>
                                                    <dt>Fiyat (Toplam) :</dt>
                                                    <dd>{{ $item->total_price }} ₺</dd>
                                                    <dt>Durum:</dt>
                                                    <dd>{{ $item->status_text }}</dd>

                                                </dl>
                                                <hr/>
                                                <h2>Kullanıcı Bilgileri</h2>
                                                <dl class="term-description">
                                                    <dt>Ad:</dt>
                                                    <dd>{{ $item->user->name }}</dd>
                                                    <dt>Soyad:</dt>
                                                    <dd>{{ $item->user->surname }}</dd>
                                                    <dt>E-mail:</dt>
                                                    <dd>{{ $item->user->email }}</dd>
                                                    <dt>Telefon:</dt>
                                                    <dd>{{ $item->user->phone }}</dd>
                                                </dl>
                                                <hr/>
                                                <h2>Genel Bilgiler</h2>
                                                <dl class="term-description">
                                                    <dt>@lang('panel.service'):</dt>
                                                    <dd>
                                                        <a href="{{ loggedPanelUser()->isCustomer() ? route('services.detail',['slug' => $item->service->slug]) : route('user.services.edit',['service' => $item->service_id]) }}">
                                                            <i class="fa fa-external-link"></i> {{ $item->service->title }}
                                                        </a>
                                                    </dd>
                                                    <dt>Oluşturma Tarihi:</dt>
                                                    <dd>{{ createdAt($item->created_at) }}</dd>
                                                    <dt>Son Güncelleme :</dt>
                                                    <dd>{{ createdAt($item->updated_at) }}</dd>
                                                    <dt>Email Onayı :</dt>
                                                    <dd>{{ $item->verified_at ? createdAt($item->verified_at) :'Onaylanmadı' }}</dd>
                                                </dl>
                                                <hr/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <script src="/admin_files/plugins/jquery-datatable/jquery.dataTables.min.js"></script>
    <!-- Select2 -->
    <script src="/site/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="/js/pages/app.service.detail.js"></script>
    <script src="/admin_files/bower_components/moment/min/moment.min.js"></script>
    <script>
        $(function () {
            $('select[id*="id_country"]').select2({
                placeholder: 'Ülke seçiniz'
            });
            $('select#id_state_id').select2({
                placeholder: 'Şehir seçiniz'
            });
            $('select#id_district_id').select2({
                placeholder: 'ilçe seçiniz'
            });
            $('select[id*="attributes"]').select2({
                placeholder: 'Tip seçiniz'
            });
        })
    </script>
@endsection
