@extends('admin.layouts.master')
@section('title','Firma detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> @lang('admin.home')</a>
                    › <a href="{{ route('admin.product.company.list') }}"> @lang('admin.modules.product_company.plural')</a>
                    › {{ $item->title }}
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">@lang('admin.save')</a>
                </div>
            </div>
        </div>
    </div>
    <form role="form" method="post" action="{{ route('admin.product.company.save',$item->id != null ? $item->id : 0) }}" id="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('admin.modules.product_company.title') Detay</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-row">
                            <x-input name="title" label="Firma Adı" width="3" :value="$item->title" required maxlength="50"/>
                            {{--                            <x-input name="email" type="email" label="Email" width="2" :value="$item->email" maxlength="50"/>--}}
                            <x-input name="slug" type="text" label="Slug" width="2" :value="$item->slug" disabled/>
                            <x-input name="address" type="text" label="Adres" width="4" :value="$item->address" maxlength="250"/>
                            {{--                            <x-input name="active" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->active" class="minimal"/>--}}
                            <x-input name="api_status" type="checkbox" label="Fiyatlar kontrol edilsin mi ?" width="2" :value="$item->api_status" class="minimal" help="Belirli aralıkla çalışan cron joblar bu firma için çalışsın mı?"/>
                            <x-input name="api_url" type="text" label="Api Url" width="4" :value="$item->api_url" maxlength="255" help="Acenta api XML/Json Url"/>
                            <x-input name="domain" type="text" label="Domain" width="2" :value="$item->domain" maxlength="255" help="Acenta Site"/>
                            <x-input name="image" type="file" label="Görsel" width="2" :value="$item->image" path="company"/>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Kayıt Tarihi</label>
                                <p>{{$item->created_at}}</p>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Son Güncelleme</label>
                                <p>{{$item->updated_at}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">@lang('admin.save')</button>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">@lang('admin.modules.product_company.title') Kullanıcı Bilgileri</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-row">
                            <x-input name="name" label="Ad*" width="2" :value="$item->user ? $item->user->name : ''" required maxlength="30" help="Firma ilgili kişinin Adı"/>
                            <x-input name="surname" label="Soyad" width="2" :value="$item->user ? $item->user->surname : ''"  maxlength="30" help="Firma ilgili kişinin Soyadı"/>
                            <x-input name="email" label="Email*" type="email" width="3" :value="$item->user ? $item->user->email : ''" required maxlength="255" help="Panel giriş için email adresi"/>
                            @if ($item->user_id)
                                <x-input name="password" label="Parola" type="password" width="2" :value="$item->password" maxlength="40" help="Panel giriş için şifre" />
                            @else
                                <x-input name="password" label="Parola" type="password" width="2" :value="$item->password" maxlength="40" help="Panel giriş için şifre" required />
                            @endif

                            <x-input name="phone" type="phone" label="Telefon" width="3" :value="$item->user ? $item->user->phone : ''" maxlength="30"/>
                            <x-input name="is_active" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->user ? $item->user->is_active : ''" class="minimal"/>
                            <x-input name="is_admin" type="checkbox" label="Panel Giriş?" width="1" :value="$item->user ? $item->user->is_admin : ''" class="minimal" help="Panele giriş yapabilir mi ?"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
