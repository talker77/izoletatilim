@extends('admin.layouts.master')
@section('title','İlan detay')

@section('content')
    <input type="hidden" value="{{ $item->id }}" id="serviceID">
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.services-comments.index') }}">Yorumlar</a>
                    › ({{ $item->id }}) {{ $item->user  ? $item->user->email :  '' }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="POST" action="{{ route('admin.services-comments.update',$item->id) }}" id="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Yorum Detay</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="">Kullanıcı</label>
                                <p>
                                    <a href="{{ route('admin.user.edit',$item->user_id) }}">{{ $item->user ?  $item->user->email : $item->user_id }}</a>
                                </p>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">@lang('admin.navbar.local_service')</label>
                                <p>
                                    <a href="{{ route('admin.services.edit',$item->service_id) }}">{{ $item->service ?  $item->service->title : $item->service_id }}</a>
                                </p>
                            </div>

                            <div class="form-group col-md-1">
                                <label for="">Puan</label>
                                <p>
                                    {{ $item->point }}
                                </p>
                            </div>
                            @if(isSuperAdmin())
                                <x-input name="status" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->status" class="minimal"/>
                            @else
                                <div class="form-group col-md-1">
                                    <label for="">Aktif Mi ?</label>
                                    <p>{{ $item->status ? 'Yayında' : 'Yayında Değil' }}</p>
                                </div>
                            @endif

                            <div class="form-group col-md-2">
                                <label for="">Okundu</label>
                                <p>
                                    {{ $item->read_at ?: '-' }}
                                </p>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Oluşturulma Tarihi</label>
                                <p>
                                    {{ $item->created_at }}
                                </p>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">@lang('admin.updated_at')</label>
                                <p>
                                    {{ $item->updated_at }}
                                </p>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Mesaj</label>
                                <p>
                                    {{ $item->message }}
                                </p>
                            </div>

                        </div>
                    </div>
                    @if(isSuperAdmin())
                        <div class="box-footer text-right">
                            <button type="submit" class="btn btn-success">Kaydet</button>
                        </div>
                    @endif

                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer')
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
