@extends('site.layouts.base')
@section('title','İlan Detay')
@section('header')
    <!-- Select2 -->
    <link rel="stylesheet" href="/site/modules/select2/dist/css/select2.min.css">
    <style>
        #serviceBlock a {
            margin-right: 4px;
        }

        .select2 {
            width: 100% !important;
        }
    </style>
    <link rel="stylesheet" href="/admin_files/plugins/jquery-datatable/jquery.dataTables.min.css">

@endsection

@section('content')
    <input type="hidden" id="serviceID" value="{{ $item->id }}">
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">@lang('panel.navbar.services')</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li><a href="{{ route('user.services.index') }}">@lang('panel.navbar.services')</a></li>
                <li class="active">{{ $item->title }}</li>
                @include('site.kullanici.partials.addNewServiceButton')
            </ul>
        </div>
    </div>
    <section id="content" class="gray-area">
        <div class="container">
            @include('site.layouts.partials.messages')

            <div id="main">
                @if(in_array($item->status,[\App\Models\Service::STATUS_REJECTED,\App\Models\Service::STATUS_PENDING_APPROVAL,\App\Models\Service::STATUS_PASSIVE,\App\Models\Service::STATUS_REQUIRE_ACTIVE_APPOINTMENT]))
                    <div class="alert  {{ __('panel.service_status.'.$item->status.'.class') }}">
                        <strong>{{ __('panel.service_status.'.$item->status.'.title') }}</strong> <br>{{ __('panel.service_status.'.$item->status.'.desc') }}
                    </div>
                @endif

                <div class="tab-container full-width-style arrow-left dashboard">
                    @include('site.kullanici.partials.myAccountLeftSidebar')
                    <div class="tab-content">
                        <div id="main" class="col-sms-6 col-sm-8 col-md-12">

                            <div class="booking-section travelo-box">
                                <div class="col-md-12">
                                    @if($item->id)
                                        <div class="card-information">
                                            @include('site.kullanici.services.partials.appointments')
                                        </div>
                                    @endif
                                </div>
                                <form class="booking-form" method="POST" enctype="multipart/form-data"
                                      action="{{ $item->id != null ? route('user.services.update',$item->id) : route('user.services.store') }}">
                                    @method($item->id ? 'PUT' : 'POST')
                                    @csrf
                                    <div class="alert small-box" style="display: none;"></div>

                                    <div class="person-information">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2>Genel Bilgiler</h2>
                                            </div>
                                            @if($item->id)
                                                <div class="col-md-6 pull-right text-right" id="serviceBlock">
                                                    <a href="{{ route('services.detail',['slug' => $item->slug]) }}?startDate={{ $item->service_appointments->last() ? $item->service_appointments->last()->start_date->format('Y-m-d') : date('Y-m-d') }}&endDate={{ $item->service_appointments->last() ? $item->service_appointments->last()->end_date->format('Y-m-d') : \Carbon\Carbon::now()->addDays(1)->format('Y-m-d') }}"
                                                       target="_blank"
                                                       title="Sitede Görüntüle" class=""><i class="fa fa-eye h4"></i>
                                                        Görüntüle</a>
                                                    <a href="" title="Yorumlar"><i class="fa fa-comment h4"></i>(0)
                                                        Yorumlar</a>
                                                    <a href="{{ route('user.reservations.index',['serviceId' => $item->id]) }}"
                                                       title="Rezervasyonlar"><i class="fa fa-calendar"></i>
                                                        @lang('panel.navbar.reservations')</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3 col-md-3">
                                                <label>İlan Türü <i class="fa fa-question-circle" title="Ne kiralatmak istiyorsun ?"></i></label>
                                                <div class="selector">
                                                    <select name="type_id" class="full-width" id="serviceType" required>
                                                        <option value="">İlan Türü Seçiniz</option>
                                                        @foreach($types as $type)
                                                            <option
                                                                value="{{ $type->id }}" {{ $type->id == old('type_id',$item->type_id) ? 'selected' : '' }}>{{ $type->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <x-site.input name="title" label="İlan Başlığı" width="3" help="Listeleme ve detay ekranında gözükecek ilan başlığı"
                                                              :value="$item->title" required maxlength="255"
                                                              class="input-text full-width"/>
                                            </div>

                                            <div class="col-sm-6 col-md-5">
                                                <x-site.input name="address" label="Adres" width="3"
                                                              :value="$item->address" maxlength="255"
                                                              class="input-text full-width"/>
                                            </div>

                                            <div class="col-sm-9">
                                                <label>Özellikler</label>
                                                {{--                                                <select class="form-control" multiple="multiple" id="attributes" {{ $item->type_id ? null : 'disabled' }}--}}
                                                {{--                                                name="attributes[]">--}}
                                                {{--                                                    @foreach($attributes as $attribute)--}}
                                                {{--                                                        <option--}}
                                                {{--                                                            value="{{ $attribute->id }}" {{ (isset($selected)) ?  (in_array($attribute->id,$selected['attributes']) ? 'selected' : '') : '' }}>--}}
                                                {{--                                                            {{ $attribute->title }}--}}
                                                {{--                                                        </option>--}}
                                                {{--                                                    @endforeach--}}
                                                {{--                                                </select>--}}
                                                <div class="row" id="attributeContainer">
                                                    @foreach($attributes as $attribute)
                                                        <div class="col-md-2">
                                                            <label>
                                                                <input type="checkbox" value="{{ $attribute->id }}"
                                                                       name="attributes[]"
                                                                    {{ (isset($selected)) ?  (in_array($attribute->id,$selected['attributes']) ? 'checked' : '') : '' }}> {{ $attribute->title }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <x-site.input name="person" label="Kişi Sayısı" width="12" help="Bu ilan en az fazla kaç kişi tarafından kiralanabilir. ?"
                                                              :value="$item->person ?: 1" required max="255" min="1"
                                                              class="input-text full-width"/>
                                            </div>
                                            <div class="col-sm-12">
                                                <label>Açıklama</label>
                                                <textarea class="form-control" maxlength="2000" name="description"
                                                          rows="10">{{ old('description',$item->description) }}</textarea>
                                            </div>


                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label for="">&nbsp;</label>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"
                                                               name="published_at" {{ !$item->published_at ?: 'checked' }}> İlan aktif edilsin mi ?
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-md-3">
                                                <label>İlan Kapak Görseli <i class="fa fa-question-circle"
                                                                       title="Fotoğraf boyutları : 900x500- Listeleme ekranında gözükecek olan görsel"></i></label>
                                                <input type="file" name="image" id="mainImage"
                                                       class="full-width form-control" {{ $item->id?:'required' }}/>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="{{ imageUrl('public/services',$item->image) }}" target="_blank">
                                                   <span class="help-block">
                                                         <img id="mainImagePreview" src="{{ imageUrl('public/services',$item->image) }}" alt="{{ $item->title }}"
                                                              style="max-height: 100px;max-width: 180px"/>
                                                    </span>
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                    <hr/>
                                    <div class="card-information">
                                        <h2>Bölge Bilgileri</h2>
                                        <div class="form-group row">
                                            <div class="col-sm-12 col-md-4">
                                                <x-site.select name="country_id" label="Ülke" :options="$countries"
                                                               width="12" :value="$item->country_id ?: \App\Models\Region\Country::TURKEY"
                                                               disabled
                                                               onchange="countryOnChange(this)" required
                                                               class="full-width"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <x-site.select name="state_id" label="Şehir" :options="$states"
                                                               width="12" :value="$item->state_id"
                                                               onchange="citySelectOnChange(this)" required
                                                               class="full-width"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <x-site.select name="district_id" label="İlçe" :options="$districts"
                                                               width="12" :value="$item->district_id"
                                                               required
                                                               class="full-width"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Gallery -->
                                    <div class="card-information">
                                        <h2>Galeri</h2>
                                        <input type="file" name="imageGallery[]" multiple class="form-control">
                                        <span
                                            class="help-block">Galeriye en fazla 25 adet fotoğraf ekleyebilirsiniz.</span>
                                        <div id="main">
                                            <div class="tour-packages row add-clearfix image-box">
                                                @foreach($item->images as $image)
                                                    <div class="col-sm-6 col-md-3"
                                                         id="productImageCartItem{{ $image->id }}">
                                                        <article class="box">
                                                            <figure>
                                                                <a href="{{ imageUrl('public/service-gallery',$image->title) }}"
                                                                   target="_blank">
                                                                    <img
                                                                        src="{{ imageUrl('public/service-gallery',$image->title) }}"
                                                                        width="270" height="160"
                                                                        style="width: 270px;height: 160px">
                                                                </a>
                                                                <figcaption>
                                                                    <a class="btn btn-success" target="_blank"
                                                                       href="{{ imageUrl('public/service-gallery',$image->title) }}"><i
                                                                            class="fa fa-eye"></i></a>
                                                                    <a class="btn btn-danger"
                                                                       onclick="deleteImage({{ $image->id }})"><i
                                                                            class="fa fa-trash-o"></i> Sil</a>
                                                                </figcaption>
                                                            </figure>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="form-group row">
                                        <div class="col-sm-6 col-md-6">
                                            <a href="{{ route('user.services.index') }}"
                                               class=" btn btn-large btn-danger" style="margin-right: 2px">İptal</a>
                                            @if($item->status !== \App\Models\Service::STATUS_PENDING_APPROVAL)
                                                <input type="submit" class=" btn btn-large btn-success" value="Kaydet"/>
                                            @endif
                                        </div>
                                        <div class="col-sm-6 col-md-2">

                                        </div>

                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <script src="/admin_files/plugins/jquery-datatable/jquery.dataTables.min.js"></script>
    <!-- Select2 -->
    <script src="/site/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="/js/pages/panel/panel.service.detail.js"></script>
    <script src="/admin_files/bower_components/moment/min/moment.min.js"></script>
    <script>
        $(function () {
            $('select[id*="id_country"]').select2({
                placeholder: 'Ülke seçiniz'
            });
            $('select#id_state_id').select2({
                placeholder: 'Şehir seçiniz'
            });
            $('select#id_district_id').select2({
                placeholder: 'ilçe seçiniz'
            });
            $('select[id*="attributes"]').select2({
                placeholder: 'Tip seçiniz'
            });
            const imgInp = document.getElementById("mainImage");
            imgInp.onchange = evt => {
                const [file] = imgInp.files
                if (file) {
                    $("#mainImagePreview").attr('src', URL.createObjectURL(file))
                }
            }
        })
    </script>
@endsection
