@extends('admin.layouts.master')
@section('title',__('admin.navbar.appointment'))

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.appointments') }}"> @lang('admin.navbar.appointments')</a>
                    › {{ $item->id }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="POST" action="{{ $item->id != null ? route('admin.appointments.update',$item->id) : route('admin.appointments.store') }}" id="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method($item->id ? 'PUT' : 'POST')
        <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('admin.navbar.appointment') Detay</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
{{--                            <x-select name="service_company_id" :label="__('admin.navbar.company_service')" :options="$service_companies" :value="$item->service_company_id" width="4"/>--}}
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">@lang('admin.navbar.local_service')</label>
                                <select class="form-control" id="id_service_company_id" name="service_company_id">
                                    @foreach($service_companies as $serviceCompany)
                                        <option value="{{ $serviceCompany['id'] }}" {{  $serviceCompany['id'] == $item->service_company_id ? 'selected' : '' }}>
                                            {{ $serviceCompany['title'] }} {{ $serviceCompany->company ? "({$serviceCompany->company->title})"  :'' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input name="start_date" label="Başlangıç" width="2" :value="$item->start_date" maxlength="255" type="date"/>
                            <x-input name="end_date" label="Bitiş" width="2" :value="$item->end_date" maxlength="255" type="date"/>
                            <x-input name="price" label="Fiyat/Gecelik" width="2" type="number" step="any" :value="$item->price"/>
                            <x-input name="status" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->status" class="minimal"/>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer')
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script>
        $(function () {
            $('select[id*="attributes"]').select2({
                placeholder: 'Tip seçiniz'
            });
            $('select[id*="id_service_company_id"]').select2({
                placeholder: 'Ülke seçiniz'
            });
            $('select[id*="id_state_id"]').select2({
                placeholder: 'Şehir seçiniz'
            });
            $('select[id*="id_district_id"]').select2({
                placeholder: 'İlçe seçiniz'
            });
            $("#id_store_type").on('change', function () {
                const val = $(this).val();
                console.log(val);
                if (val == 2) {
                    $("#input_redirect_to").removeAttr('disabled')
                } else {
                    $("#input_redirect_to").prop('disabled', true)
                }
            })

            var options = {
                language: 'tr',
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
                allowedContent: true
            };
            CKEDITOR.replace('editor1', options);
        })
    </script>
@endsection
