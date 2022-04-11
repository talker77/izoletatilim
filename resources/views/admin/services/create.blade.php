@extends('admin.layouts.master')
@section('title','İlan detay')

@section('content')
    <input type="hidden" value="{{ $item->id }}" id="serviceID">
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>

                    › <a href="{{ route(isSuperAdmin() ? 'admin.services' : 'admin.services.stores') }}">
                        @lang('admin.navbar.'.(isSuperAdmin() ? 'local_services' : 'my_services'))
                    </a>
                    › {{ $item->title }}

                </div>
                <div class="col-md-2 text-right mr-3 ">
                    @if(!is_null($item->slug) and $item->store_type == \App\Models\Service::STORE_TYPE_LOCAL)
                        <a target="_blank"
                           href="{{ route('services.detail',$item->slug) }}?startDate={{ $item->service_appointments->last() ? $item->service_appointments->last()->start_date->format('Y-m-d') : date('Y-m-d') }}&endDate={{ $item->service_appointments->last() ? $item->service_appointments->last()->end_date->format('Y-m-d') : \Carbon\Carbon::now()->addDays(1)->format('Y-m-d') }}">
                            @lang('admin.product.show_on_site') <i class="fa fa-eye"></i>
                        </a>&nbsp;&nbsp;&nbsp;
                        &nbsp;@endif
                    @if ($item->store_type == \App\Models\Service::STORE_TYPE_LOCAL)
                        <a href="{{ route('admin.services-comments.index',['serviceId' => $item->id]) }}"><i class="fa fa-comments"></i>{{ $item->comments()->count() }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($item->status == \App\Models\Service::STATUS_PENDING_APPROVAL)
        <div class="row">
            <div class="col-md-10">
                <div class="alert alert-warning" role="alert">
                    Bu ilanın yayına girmesi için onaylamanız gerekmektedir

                </div>
            </div>
            <div class="col-md-2">
                <form action="{{ route('admin.services.reject',['service' => $item->id]) }}" method="POST" class="pull-left col-md-12" style="padding:0">
                    @csrf
                    <input type="submit" class="btn btn-danger btn-block btn-sm" value="Reddet">
                </form>
                <form action="{{ route('admin.services.approve',['service' => $item->id]) }}" method="POST" class="col-md-12" style="padding:0;padding-top: 2px">
                    @csrf
                    <input type="submit" class="btn btn-success btn-block btn-sm" value="Onayla">
                </form>
            </div>
        </div>

    @endif
    <div class="row">
        <form role="form" method="POST" action="{{ $item->id != null ? route('admin.services.update',$item->id) : route('admin.services.store') }}" id="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method($item->id ? 'PUT' : 'POST')
        <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('admin.navbar.local_service') Detay</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="255"/>
                            <x-input name="slug" label="Slug" width="3" :value="$item->slug" maxlength="255" placeholder="İlan Url" disabled/>
                            @if ($adUser->role_id == \App\Models\Auth\Role::ROLE_SUPER_ADMIN)
                                <x-input name="point" type="number" label="Puan" width="1" :value="$item->point" step="any"/>
                            @else
                                <div class="form-group col-md-1">
                                    <label for="">Puan</label>
                                    <p>{{ $item->point }}</p>
                                </div>
                            @endif

                            <x-input name="published_at" type="checkbox" label="Aktif Mi ?" width="1" :value="(bool)$item->published_at" class="minimal"/>
                            <x-select name="type_id" label="Tip" :options="$types" :value="$item->type_id"/>
                            <x-input name="image" type="file" label="Görsel" width="2" :value="$item->image" path="services" help="Boyut : 900x500"/>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-11">
                                <label for="exampleInputEmail1">Özellikler</label>
                                <select class="form-control" multiple="multiple" id="attributes" name="attributes[]">
                                    @foreach($attributes as $attribute)
                                        <option value="{{ $attribute->id }}" {{ (isset($selected)) ?  (in_array($attribute->id,$selected['attributes']) ? 'selected' : '') : '' }}>
                                            {{ $attribute->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="exampleInputEmail1">Durum</label>
                                <select name="status" class="form-control" id="status">
                                    @foreach(__('panel.service_status') as $index => $status)
                                        <option value="{{ $index }}" {{ $item->status == $index ? 'selected' : '' }}>{{ $status['short_title'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input name="address" label="Adres Bilgisi" width="10" :value="$item->address" maxlength="255"/>
                            <x-input name="person" type="number" label="Kişi Sayısı" width="2" :value="$item->person" maxlength="255" min="1" max="255"/>
                            <div class="col-md-12">
                                <label for="exampleInputEmail1">Açıklama</label>
                                <textarea class="textarea" placeholder="" id="editor1"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                          name="description">{{ old('description',$item->description )}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </div>

                @include('admin.services.partials.galleries')
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Bölge Bilgileri</h3>
                        </div>
                        <div class="box-body">
                            <x-select name="country_id" label="Ülke" :options="$countries" width="12" :value="$item->country_id" onchange="countryOnChange(this)" required/>
                            <x-select name="state_id" label="Şehir" :options="$states" width="12" :value="$item->state_id" onchange="citySelectOnChange(this)"/>
                            <x-select name="district_id" label="İlce" :options="$districts" width="12" :value="$item->district_id"/>
                        </div>
                    </div>
                </div>

                @if($adUser->role_id == \App\Models\Auth\Role::ROLE_SUPER_ADMIN)
                    <div class="row">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Link Bilgileri</h3>
                            </div>
                            <div class="box-body">
                                <x-select name="store_type" label="Uygulama Tipi" :options="$storeTypes" width="12" key="0" option-value="1" :value="$item->store_type" required/>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('admin.services.partials.appointments')
        </div>
    </div>
@endsection
@section('footer')
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script src="/admin_files/js/pages/admin.services.js"></script>
    <script>
        $(function () {
            $('select[id*="attributes"]').select2({
                placeholder: 'Tip seçiniz'
            });
            $('select[id*="id_country_id"]').select2({
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
