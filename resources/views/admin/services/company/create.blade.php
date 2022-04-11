@extends('admin.layouts.master')
@section('title','İlan detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.services.company.list') }}">@lang('admin.navbar.company_services')</a>
                    › {{ $item->title }}
                </div>
                <div class="col-md-2 text-right ">
                    <a href="#" title="kullanıcılar {{ $count['click']->click }} defa tıkladı.">
                        <i class="fa fa-eye"> {{ $count['click']->click }} Tıklanma</i>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <form role="form" method="POST" action="{{ $item->id != 0 ? route('admin.services.company.update',$item->id) : route('admin.services.company.store') }}" id="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method($item->id ? 'PUT' : 'POST')
        <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __('admin.navbar.service') }} Detay</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="100" required/>
                            <x-input name="status" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->status" class="minimal"/>
                            <x-input name="redirect_to" label="Yönlendir" width="3" :value="$item->redirect_to" maxlength="255" placeholder="Yönlendirilecek url"/>
                            <x-select name="company_id" :label="__('admin.company')" :options="$companies" :value="$item->company_id" required/>
                            <x-select name="service_id" :label="__('admin.navbar.service')" :options="$services" :value="$item->service_id"/>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </div>
            </div>
            <!-- appointments -->

        </form>
    </div>
    @if ($item->id)
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.appointments')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="table-appointments">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fiyat</th>
                            <th>Başlangıc</th>
                            <th>Bitiş</th>
                            <th>Durum</th>
                            <th>@lang('admin.created_at')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('footer')
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script>
        $(function () {

            $('select#id_company_id').select2({
                placeholder: 'Firma seçiniz'
            });
            $('select#id_service_id').select2({
                placeholder: 'İlan seçiniz'
            });
        })
        $('#table-appointments').DataTable({
            processing: true,
            serverSide: true,
            bFilter: false,
            ajax: {
                url: '/admin/company-services/appointments/{{ $item->id }}'
            },
            "language": {
                "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
            },
            columns: [
                {data: 'id', name: 'id'},
                {
                    data: 'price', name: 'price',
                    render: function (data, type, row) {
                        return `${data} ₺`
                    }
                },
                {
                    data: 'start_date', name: 'start_date',
                    render: function (data, type, row) {
                        return createdAt(data)
                    }
                },
                {
                    data: 'end_date', name: 'end_date',
                    render: function (data, type, row) {
                        return createdAt(data)
                    }
                },
                {
                    data: 'status', name: 'status',
                    render: function (data, type, row) {
                        return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
                    }
                },
                {
                    data: 'created_at', name: 'created_at',
                    render: function (data, type, row) {
                        return createdAt(data)
                    }
                },

            ],
            order: [0, 'desc'],
            pageLength: 10
        });
    </script>
@endsection
