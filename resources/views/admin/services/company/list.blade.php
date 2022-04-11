@extends('admin.layouts.master')
@section('title','İlan/Oteller')
@section('content')
    <input type="hidden" value="/storage/services/" id="imagePrefix">
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › @lang('admin.navbar.company_services')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.services.company.new') }}"><i class="fa fa-plus"></i>&nbsp;Ekle</a>
                    <a href="{{ route('admin.services.company.list') }}"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
                <div class="col-xs-12">
            @include('admin.services.company.partials.service-company-list-filter')
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.company_services')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Acenta Başlık</th>
                                <th>@lang('admin.navbar.local_service') <i class="fa fa-external-link"></i> <i class="fa fa-question-circle" title="Yerel Villa(Otel vd.) ile eşleşen"></i></th>
                                <th>@lang('admin.company') <i class="fa fa-external-link"></i> </th>
                                <th>Durum</th>
                                <th>@lang('admin.created_at')</th>
                                <th>@lang('admin.updated_at')</th>
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
    <script src="/admin_files/js/pages/admin.services.company.js"></script>
@endsection
