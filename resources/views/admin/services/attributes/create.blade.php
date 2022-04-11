@extends('admin.layouts.master')
@section('title','İlan detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.services.attribute.list') }}"> İlan Özellikleri</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="POST" action="{{ $item->id != 0 ? route('admin.services.attribute.update',$item->id) : route('admin.services.attribute.store') }}" id="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method($item->id ? 'PUT' : 'POST')
        <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Özellik Detay</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="100"/>
                            <x-select name="type_id" label="Tip" :options="$types" :value="$item->type_id" required/>
                            <x-input name="icon" label="Icon" width="3" :value="$item->icon" maxlength="100"/>
                            <x-input name="order" type="number" label="Sıra Numarası" width="2" :value="$item->order"/>
                            <x-input name="status" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->status" class="minimal"/>
                            <x-input name="show_menu" type="checkbox" label="Menüde Göster ?" width="2" :value="$item->show_menu" class="minimal"/>
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
            $('select[id*="id_type_id"]').select2({
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
