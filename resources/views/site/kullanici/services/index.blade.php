@extends('site.layouts.base')
@section('title','Favorilerim')

@section('content')
    @include('site.kullanici.services.partials.excel-import-modal')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">@lang('panel.navbar.services')</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="active">@lang('panel.navbar.services')</li>
                @include('site.kullanici.partials.addNewServiceButton')
            </ul>
        </div>
    </div>
    <section id="content" class="gray-area">
        <div class="container">
            <div id="main">
                <div class="tab-container full-width-style arrow-left dashboard">
                    @include('site.kullanici.partials.myAccountLeftSidebar')
                    <div class="tab-content">
                        @include('site.layouts.partials.messages')
                        <div id="booking" class="tab-pane fade in active">
                            <h2>@lang('panel.navbar.services')da Filtrele</h2>
                            <div class="filter-section gray-area clearfix">
                                <form id="typeFilterForm">
                                    <label class="radio radio-inline">
                                        <input type="radio" name="type" {{ request()->get('type')?:'checked' }} value=""
                                               onchange="document.getElementById('typeFilterForm').submit()"/>
                                        Tümü
                                    </label>
                                    @foreach($types as $type)
                                        <label class="radio radio-inline">
                                            <input type="radio" name="type"
                                                   onchange="document.getElementById('typeFilterForm').submit()"
                                                   {{ $type->id == request()->get('type') ? 'checked' : '' }}
                                                   value="{{ $type->id }}"/>
                                            {{ $type->title }}
                                        </label>
                                    @endforeach

                                    <div class="pull-right col-md-6 action">
                                        <a class="button btn-small green" href="{{ route('user.services.create') }}">Yeni İlan
                                            Ekle</a>
                                        <a class="button btn-small orange" data-toggle="modal" data-target="#excelImport">
                                            <i class="fa fa-file-excel"></i>&nbsp; Excel ile İlan Ekle
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <div class="row listing-style2 add-clearfix">
                                @foreach($services as $service)
                                    <div class="col-sm-6 col-md-4">
                                        <article class="box">
                                            <figure>
                                                <a class="" title="{{ $service->title }}"
                                                   href="{{ route('user.services.edit',$service->id) }}">
                                                    <img width="300" height="160"
                                                         src="{{ imageUrl('public/services',$service->image) }}"></a>
                                            </figure>
                                            <div class="details">
                                                <h4 class="box-title">
                                                    <a href="{{ route('user.services.edit',$service->id) }}"
                                                       title="View all">{{ $service->title }}</a>
                                                </h4>
                                                <label class="price-wrapper">
                                                    {{ $service->location_text }}
                                                </label>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                            {!! $services->appends($_GET)->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
