@extends('admin.layouts.master')
@section('title','Kullancı Listesi')


@section('content')
    <x-breadcrumb :first="__('admin.users')">
        <a href="{{ route('admin.user.new') }}"> <i class="fa fa-plus"></i> @lang('admin.add_new_user')</a>
    </x-breadcrumb>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.users')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>@lang('admin.name')</th>
                            <th>@lang('admin.surname')</th>
                            <th>@lang('admin.email')</th>
                            <th>@lang('admin.admin') <i class="fa fa-question-circle" title="@lang('admin.can_access_admin')"></i></th>
                            <th>@lang('admin.role')</th>
                            <th>@lang('admin.updated_at')</th>
                            <th>@lang('admin.created_at')</th>
                            <th>@lang('admin.status')</th>
                            <th>#</th>
                        </tr>
                        </thead>

                    </table>
                    <div class="text-right"> {{ $list->appends(['q' => request('q')])->links() }}</div>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.users.js"></script>
@endsection
