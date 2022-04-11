@extends('admin.layouts.master')
@section('title','İlan/Oteller')
@section('header')
    @if (authAdminUser()->role_id != \App\Models\Auth\Role::ROLE_SUPER_ADMIN)
        <style>
            .delete-item {
                display: none !important;
            }
        </style>
    @endif
@endsection
@section('content')
    <input type="hidden" value="/storage/services/" id="imagePrefix">
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › @lang('admin.navbar.service_comments')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.services-comments.index') }}"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.service_comments')</h3>
                    <div class="box-tools">
                        @if (request('serviceId'))
                            <a href="{{ route('admin.services-comments.index') }}" title="filtrelemeyi kaldır">
                                <span class="badge badge-danger">@lang('admin.navbar.local_service') : {{ request('serviceId') }} <i class="fa fa-times"></i></span>
                            </a>
                        @endif

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="serviceTable">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>@lang('admin.navbar.local_service') <i class="fa fa-external-link"></i></th>
                            <th>Kullanıcı <i class="fa fa-external-link"></i></th>
                            <th>Puan</th>
                            <th>Yorum</th>
                            <th>Durum</th>
                            <th>Okundu?</th>
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
        $('#serviceTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/tables/service-comments',
                data: {
                    serviceId: "{{ request('serviceId') }}"
                }
            },
            "language": {
                "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
            },
            columns: [
                {data: 'id', name: 'id'},
                {
                    data: 'service_id', name: 'service_id',
                    render: function (data, type, row) {
                        return row['service']
                            ? `<a href="/admin/services/${data}/edit">${row['service']['title']}</a>`
                            : data
                    }
                },
                {
                    data: 'user_id', name: 'user_id',
                    render: function (data, type, row) {
                        return row['user']
                            ? `<a href="/admin/user/edit/${data}">${row['user']['email']}</a>`
                            : data
                    }
                },
                {data: 'point', name: 'point'},
                {data: 'message', name: 'message'},
                {
                    data: 'status', name: 'status',
                    render: function (data, type, row) {
                        return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
                    }
                },
                {
                    data: 'read_at', name: 'read_at',
                    render: function (data, type, row) {
                        return data
                            ? `<i class="fa fa-check text-green" title="${data}"></i>`
                            : `<i class="fa fa-times text-danger" title="${data}"></i>`
                    }
                },
                {
                    data: 'created_at', name: 'created_at',
                    render: function (data, type, row) {
                        return createdAt(data)
                    }
                },

                {
                    data: 'id', name: 'id', orderable: false,
                    render: function (data) {
                        return `<a href='/admin/services-comments/${data}/edit'><i class='fa fa-edit'></i></a> &nbsp;` +
                            `<a href="#" class="delete-item" data-id="${data}"><i class='fa fa-trash'></i></a>`
                    }
                }
            ],
            order: [0, 'desc'],
            pageLength: 10
        });
    </script>
@endsection
