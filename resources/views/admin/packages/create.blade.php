@extends('admin.layouts.master')
@section('title','Hizmet detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.packages.index') }}"> Paketler</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="POST" action="{{ $item->id != 0 ? route('admin.packages.update',$item->id) : route('admin.packages.store') }}" id="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method($item->id ? 'PUT' : 'POST')
        <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detay</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="100"/>
                            <x-input name="slug" label="Slug" width="3" :value="$item->slug" required maxlength="100"/>
                            <x-input name="slug" label="Slug" width="6" :value="$item->description" />
                            <x-input name="day" label="Gün" width="2" :value="$item->day" required type="number" />
                            <x-input name="price" label="Fiyat" width="2" :value="$item->price" required type="number" step="any"/>
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
