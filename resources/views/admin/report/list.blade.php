@extends('admin.layouts.master')
@section('title','Hizmetler/Oteller')
@section('content')
    <input type="hidden" value="/storage/services/" id="imagePrefix">
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › @lang('admin.navbar.report')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.report') }}"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.report')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="reportTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tür</th>
                                <th>İlişkili Veri</th>
                                <th>Tıklanma Sayısı</th>
                                <th>Güncellenme Tarihi</th>
                                <th>Oluşturulma Tarihi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.reports.js"></script>
@endsection
