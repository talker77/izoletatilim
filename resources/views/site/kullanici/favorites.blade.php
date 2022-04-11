@extends('site.layouts.base')
@section('title','Favorilerim')

@section('content')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">Favorilerim</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="active">Favorilerim</li>
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
                        <div id="" class="tab-pane fade in active">
                            <h2>Favoriye Eklediklerim</h2>
                            @include('site.layouts.partials.messages')
                            <div class="hotel-list">
                                <div class="row image-box hotel listing-style1">

                                    @forelse($favorites as $favorite)
                                        <div class="col-sm-6 col-md-3">
                                            <article class="box">
                                                <figure>
                                                    <a href="{{ route('services.gallery',$favorite->service->slug) }}"
                                                       class="hover-effect popup-gallery">
                                                        <img width="270" height="160"
                                                             alt="{{ $favorite->service->title }}"
                                                             src="{{ imageUrl('public/services/thumb',$favorite->service->image) }}"></a>
                                                </figure>
                                                <div class="details">
                                                <span class="price">
                                                    <small>ort/gece</small>
                                                    {{ round($favorite->service->service_appointments()->avg('price')) }} ₺
                                                </span>
                                                    <h4 class="box-title" title="{{ $favorite->service->title }}">{{ str_limit($favorite->service->title,14) }}
                                                        <small>{{ $favorite->service->location_text }}</small></h4>
                                                    <div class="feedback">
                                                        <div data-placement="bottom" data-toggle="tooltip"
                                                             class="five-stars-container"
                                                             title="{{ $favorite->service->star }} yıldız"><span
                                                                style="width: {{ $favorite->service->star_percent }}%;"
                                                                class="five-stars"></span></div>
                                                        <span class="review">{{ $favorite->service->active_comments->count() }} yorum</span>
                                                    </div>
                                                    <div class="action">
                                                        <form
                                                            action="{{ route('user.favorites.delete',['favorite' => $favorite]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="button btn-small green"
                                                               href="{{ route('services.detail',['slug' => $favorite->service->slug]) }}">Göster</a>
                                                            <button class="button btn-small red"
                                                                    data-box="40.463667, -3.749220">Kaldır
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @empty
                                        <div class="col-sm-12 col-md-12">
                                            <h4 class="grey help-block">Favorinizde herhangi bir @lang('panel.service')
                                                bulunmuyor.</h4>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
