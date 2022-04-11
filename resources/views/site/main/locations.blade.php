@extends('site.layouts.base')
@section('title',$site->title)
@section('header')
    <title>Bölgeler</title>
@endsection
@section('content')
    @php

            function getRedirectUri($location){
     $startDate = \Carbon\Carbon::now()->format('Y-m-d');
              return route('services',['startDate' => $startDate,'country' => $location->country_id,'state' => $location->state_id,'district' => $location->district_id]);
            }
    @endphp
    <section id="content">
        <div class="container">
            <div id="main">
                <div class="gallery-filter box">
                    <a href="{{ route('locations') }}" class="button btn-medium {{ request()->route('region') ?:'active' }}" data-filter="filter-all">Tümü</a>
                    @foreach ($regions as $region)
                        <a href="{{ route('locations',['region' => $region->title]) }}"
                           class="button btn-medium {{ request()->route('region.title') == $region->title ? 'active' : '' }}">{{ $region->title }}</a>
                    @endforeach
                </div>
                <div class="items-container isotope row image-box style9">
                    @foreach($locations as $location)
                        <div class="iso-item col-xs-12 col-sms-3 col-sm-3 col-md-3 filter-all filter-{{ $location->type_id }}">
                            <article class="box">
                                <figure>
                                    <a class="hover-effect" title="" href="{{ getRedirectUri($location) }}">
                                        <img width="370" height="190" alt="" src="/storage/locations/{{ $location->image }}">
                                    </a>
                                </figure>
                                <div class="details">
                                    <a href="{{ getRedirectUri($location) }}">
                                        <h4 class="box-title">
                                            {{ $location->title }}<small>{{ $location->state ? $location->state->title : '' }}, {{  $location->country->title}}
                                            </small>

                                        </h4></a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
                {{ $locations->appends(request()->all())->links() }}
            </div>
        </div>
    </section>
@endsection
