@extends('admin.layouts.master')
@section('title','İlan detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.locations') }}"> Bölge</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="POST" action="{{ $item->id != null ? route('admin.locations.update',$item->id) : route('admin.locations.store') }}" id="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method($item->id ? 'PUT' : 'POST')
        <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Bölge Detay</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="255"/>
                            <x-input name="slug" label="Slug" width="3" :value="$item->slug" maxlength="255" placeholder="Bölge Url" help="Url kısmında gözüken slugify edilmiş sutun"/>
                            <x-input name="status" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->status" class="minimal"/>
                            <x-select name="type_id" label="Tür" :options="$types" :value="$item->type_id"/>
                            <x-input name="image" type="file" label="Görsel" width="2" :value="$item->image" path="locations" help="Boyut : 370x190"/>
                        </div>
                        <div class="row">
                            <x-input name="description" label="Kısa Açıklama" width="12" :value="$item->description" maxlength="255" placeholder="Konum,Bölge hakkında kısa açıklama"/>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </div>
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
            </div>
        </form>
    </div>
@endsection
@section('footer')
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script>
        $(function () {
            $('select[id*="id_type"]').select2({
                placeholder: 'Tür seçiniz'
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
            $("#id_store_type").on('change',function (){
                const val = $(this).val();
                console.log(val);
                if (val == 2){
                    $("#input_redirect_to").removeAttr('disabled')
                }else{
                    $("#input_redirect_to").prop('disabled',true)
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
