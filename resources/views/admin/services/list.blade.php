
@extends('admin.layouts.master')
@section('title','Hizmetler/Oteller')
@section('content')
    <input type="hidden" value="/storage/services/" id="imagePrefix">
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › @lang('admin.navbar.local_services')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.services.create') }}"><i class="fa fa-plus"></i>&nbsp;Ekle</a>
                    <a href="{{ route('admin.services') }}"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @include('admin.services.partials.service-list-filter')
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.local_services')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="serviceTable">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Başlık</th>
                            <th>Tip</th>
                            <th>Ülke</th>
                            <th>Şehir</th>
                            <th>Görsel</th>
                            <th>Puan</th>
                            <th>Güncellenme Tarihi</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>#</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>

        $(function () {
            $('select[id*="company"],#serviceTypeFilter,#typeFilter,#countryFilter').select2({});
        })
    </script>
    <script src="/admin_files/js/pages/admin.services.js"></script>
@endsection
