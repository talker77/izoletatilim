@extends('admin.layouts.master')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> @lang('admin.home')</a>
                    ›@lang('admin.modules.product_company.plural')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.product.company.new') }}"> <i class="fa fa-plus"></i> @lang('admin.add')</a>&nbsp;
                    <a href="{{ route('admin.product.company.list') }}"><i class="fa fa-refresh"></i>&nbsp;@lang('admin.refresh')</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Firma Adı</th>
                                <th>Email</th>
                                <th>Ad & Soyad</th>
                                <th>Telefon</th>
                                <th>Durum</th>
                                <th>Panel Durum <i class="fa fa-question-circle" title="Panel Giriş Durumu ?"></i></th>
                                <th>#</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="text-right"> {{ $list->appends(['q' => request('q')])->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.companies.js"></script>
@endsection
