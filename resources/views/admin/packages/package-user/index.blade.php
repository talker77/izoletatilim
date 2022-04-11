@extends('admin.layouts.master')
@section('title','Paketler')
@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    <a href="{{ route('admin.packages.index') }}"> ›  Paketler</a>
                    › @lang('admin.navbar.packages_transactions')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.packages.new') }}"><i class="fa fa-plus"></i>&nbsp;Ekle</a>
                    <a href="{{ route('admin.packages.index') }}"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.packages_transactions')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Kullanıcı</th>
                                <th>Kullanıcı Mail</th>
                                <th>Paket</th>
                                <th>Başlangıç</th>
                                <th>Bitiş</th>
                                <th>Fiyat</th>
                                <th>Ödendi ?</th>
                                <th>Son Güncelleme</th>
                                <th>Oluşturma</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.packages.transactions.js"></script>
@endsection


