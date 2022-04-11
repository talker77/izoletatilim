@extends('site.layouts.base')
@section('title','Rezervasyonlar')
@section('header')
    <link rel="stylesheet" href="/site/modules/jquery-datatable/jquery.dataTables.min.css">

@endsection
@section('content')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">@lang('panel.navbar.comments')</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="active">@lang('panel.navbar.comments')</li>
                @include('site.kullanici.partials.addNewServiceButton')
            </ul>
        </div>
    </div>
    <section id="content" class="gray-area">
        <div class="container">
            <div id="main">
                <div class="tab-container full-width-style arrow-left dashboard">
                    @include('site.kullanici.partials.myAccountLeftSidebar')
                    <div class="tab-content">

                        <div id="booking" class="tab-pane fade in active">

                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>@lang('panel.navbar.comments')</h3>
                                    </div>
                                    <div class="col-md-6 pull-right text-right">
                                        @foreach(request()->all() as $key => $value)
                                            <a href="{{ route('user.reservations.index',request()->except($key)) }}">
                                            <span class="badge badge-success">
                                                 {{ __("panel.reservations.filters.".$key) }} : {{ $value }}
                                                <i class="fa fa-times"></i>
                                            </span>
                                            </a>
                                        @endforeach

                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="col-md-12">
                                    <table class="table table-hover table-bordered" id="service-comments">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>@lang('panel.service')</th>
                                                <th>Kullanıcı</th>
                                                <th>Puan</th>
                                                <th>Yorum</th>
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
        </div>
    </section>
@endsection
@section('footer')
    <script src="/admin_files/plugins/jquery-datatable/jquery.dataTables.min.js"></script>
    <script src="/js/pages/app.service.comments.js"></script>
    <script src="/admin_files/bower_components/moment/min/moment.min.js"></script>
@endsection
