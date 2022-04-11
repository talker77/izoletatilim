@extends('site.layouts.base')
@section('title','Paketlerim')
@section('header')
    <link rel="stylesheet" href="/site/css/packages.css">
    <link rel="stylesheet" href="/site/modules/jquery-datatable/jquery.dataTables.min.css">
@endsection
@section('content')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">@lang('panel.navbar.packages')</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="active">@lang('panel.navbar.packages')</li>
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
                            <h1 class="no-margin skin-color">@lang('panel.navbar.packages')</h1>
                            <br/>
                            @if($currentPackage)
                                @include('site.kullanici.packages.partials.success')
                            @else
                                <div class="alert alert-danger alert-danger-cs" role="alert">
                                    Aktif bir  paketiniz bulunmuyor . Yeni bir @lang('panel.service') ekleyebilmek veya var olan ilanlarınızı yayında tutabilmek için lütfen paket alınız.
                                </div>
                            @endif
                            <div class="row block">
                                <div class="col-md-12 ">
                                    <div class="snip1214">
                                        @foreach($packages as $package)
                                            <div class="plan {{ $currentPackageId == $package->id ? 'featured' : '' }}">
                                                <h3 class="plan-title">
                                                    {{ $package->title }}
                                                </h3>
                                                <div class="plan-cost">
                                                    <span class="plan-price">{{ $package->price }} ₺</span>
                                                    <span class="plan-type">/ {{ $package->day }} Gün</span>
                                                    @if ($currentPackageId ==  $package->id)
                                                        <br><span class="text-block">Mevcut Paket</span>
                                                    @endif
                                                </div>
                                                <ul class="plan-features">
                                                    <li><i class="ion-android-time"> </i>Geçerlilik Süresi
                                                        : {{ $package->day }} Gün
                                                    </li>
                                                    <li><i class="ion-checkmark"> </i>İlan Sayısı : Sınırsız</li>
                                                    <li><i class="ion-checkmark"> </i>Aylık Tutar : {{ number_format(($package->price / $package->day) * 30,2) }} ₺</li>
                                                </ul>
                                                @if ($currentPackageId != $package->id)
                                                    <div class="plan-select">
                                                        <a href="{{ route('user.packages.show',['package' => $package->id]) }}">
                                                            Paketi Seç
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="plan-select">
                                                        <a href="#" style="background-color: green">Mevcut Paket</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- packages -->
                        <div class="row-block">
                            <div class="col-md-12 table-responsive">
                                <h3>Geçmiş İşlemler</h3>
                                <table class="table table-hover table-bordered" id="transactions">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Paket</th>
                                        <th>Başlangıç</th>
                                        <th>Bitiş</th>
                                        <th>Ücret</th>
                                        <th>Tarih</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="/admin_files/bower_components/moment/min/moment.min.js"></script>
    <script src="/admin_files/plugins/jquery-datatable/jquery.dataTables.min.js"></script>
    <script src="/js/pages/panel/panel.packages.js"></script>
@endsection
