@extends('admin.layouts.master')
@section('title', __('admin.navbar.appointment'))
@section('content')
    <input type="hidden" value="/storage/services/" id="imagePrefix">
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › @lang('admin.navbar.appointment')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.appointments.create') }}"><i class="fa fa-plus"></i>&nbsp;Ekle</a>
                    <a href="{{ route('admin.appointments') }}"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.appointment')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>@lang('admin.navbar.local_service') <i class="fa fa-external-link"></i></th>
                                <th> @lang('admin.navbar.company_service') <i class="fa fa-external-link"></i></th>
                                <th>Fiyat</th>
                                <th>Başlangıç</th>
                                <th>Bitiş</th>
                                <th>Durum</th>
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
    <script src="/admin_files/js/pages/admin.appointments.js"></script>
@endsection
