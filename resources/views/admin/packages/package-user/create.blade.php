@extends('admin.layouts.master')
@section('title','İlan detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.packages.index') }}"> Paketler</a>
                    › <a href="{{ route('admin.packages.transactions.index') }}">@lang('admin.navbar.packages_transactions')</a>
                    › # {{ $item->id }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="POST" action="{{ $item->id != 0 ? route('admin.packages.transactions.update',$item->id) : route('admin.packages.transactions.store',['user' => request()->get('user')]) }}" id="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method($item->id ? 'PUT' : 'POST')
        <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('admin.navbar.packages_transactions') Detay # {{ $item->id }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <x-input name="user_id" label="Kullanıcı" width="2" :value="$user->full_name" disabled/>
                            <x-input name="email" label="Kullanıcı Email" width="2" :value="$user->email" disabled/>
                            <x-select name="package_id" label="Paket" :options="$packages" :value="$item->package_id" required/>
                            <x-input name="started_at" label="Başlangıç" width="2" :value="$item->started_at ? $item->started_at->format('Y-m-d') : null" required type="date"/>
                            <x-input name="expired_at" label="Bitiş Tarihi" width="2" :value="$item->expired_at ? $item->expired_at->format('Y-m-d') : null" required type="date"/>
                            <x-input name="price" label="Fiyat" width="2" :value="$item->price" disabled/>
                            <x-input name="is_payment" type="checkbox" label="Ödendi Mi ?" width="1" :value="$item->is_payment" class="minimal"/>
                            <x-input name="installment_count" label="Taksit Sayısı" width="1" :value="$item->installment_count" disabled/>
                            <div class="form-group col-md-12">
                                <textarea name="" id="" rows="30" class="form-control ">{{json_encode( $item->payment_info,JSON_PRETTY_PRINT)}}</textarea>
                            </div>
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

