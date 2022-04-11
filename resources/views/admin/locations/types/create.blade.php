@extends('admin.layouts.master')
@section('title','İlan detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.locations.types') }}"> Bölge Tür</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="POST" action="{{ $item->id != 0 ? route('admin.locations.type.update',$item->id) : route('admin.locations.type.store') }}" id="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method($item->id ? 'PUT' : 'POST')
        <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detay</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="100"/>
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
