@extends('site.layouts.base')
@section('title',$site->title)
@section('header')
    <title>Villalar</title>
    <link rel="stylesheet" href="site/modules/jquery-pagination/dist/bs-pagination.min.css">
    <link rel="stylesheet" href="site/css/services/services-list.css">
@endsection
@section('content')
    <input type="hidden" id="hdnPerPage" value="{{ \App\Models\Service::PER_PAGE }}">
    <input type="hidden" id="hdnCanFilterMinPrice" value="{{ $minPrice  }}">
    <input type="hidden" id="hdnCanFilterMaxPrice" value="{{ $maxPrice  }}">

    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">Arama Sonuçları</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="active">Arama Sonuçları</li>
            </ul>
        </div>
    </div>

    <section id="content">
        <div class="container">
            <div id="main">
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        @include('site.service.partials.left-sidebar')
                    </div>
                    <div class="col-sm-8 col-md-9">
                        <div class="sort-by-section clearfix">
                            <form action="{{ route('services') }}" method="GET">
                                <input type="hidden" name="minPrice" id="hdnMinPrice"
                                       value="{{ Request::get('minPrice',0) }}">
                                <input type="hidden" name="maxPrice" id="hdnMaxPrice"
                                       value="{{ Request::get('maxPrice') }}">
                                <input type="hidden" name="attributes" id="hdnSelectedAttributes" value="">
                                <input type="hidden" name="point" id="hdnFilterPoint"
                                       value="{{ Request::get('point') }}">
                                <input type="hidden" name="state" id="hdnState" value="{{ Request::get('state') }}">
                                <input type="hidden" name="country" id="hdnCountry"
                                       value="{{ Request::get('country') }}">
                                <input type="hidden" name="district" id="hdnDistrict"
                                       value="{{ Request::get('district') }}">
                                <input type="hidden" name="type" id="type" value="{{ request('type') }}">

                                <ul class="sort-bar clearfix block-sm">
                                    <li class="sort-by-name">
                                        <label for="">Konum</label>
                                        <div class="form-group">
                                            <input type="text" class="input-text full-width"
                                                   placeholder="Şehir , ilçe veya bölge" name="query" id="villaSearch"
                                                   value="{{ request()->get('query') }}"/>
                                        </div>
                                    </li>
                                    <li class="sort-by-price">
                                        <label for="">Giriş</label>
                                        <input type="date" name="startDate" class="input-text full-width" required
                                               min="{{ now()->format('Y-m-d') }}"
                                               placeholder="Giriş" value="{{ request()->get('startDate') }}"/>
                                    </li>
                                    <li class="clearer visible-sms"></li>
                                    <li>
                                        <label for="">Çıkış</label>
                                        <input type="date" name="endDate" class="input-text full-width" required
                                               min="{{ date('Y-m-d',strtotime('+1 day')) }}"
                                               placeholder="Çıkış" value="{{ request()->get('endDate') }}"/>
                                    </li>
                                    <li>
                                        <label for="">Kişi</label>
                                        <div class="selector">
                                                <select class="full-width" name="person" id="personSelect">
                                                @foreach(range(1,15) as $range)
                                                    <option value="{{ $range }}" {{ request()->get('person',1) == $range ? 'checked':'' }}>{{ $range }}</option>
                                                @endforeach
                                            </select><span
                                                class="custom-select full-width">{{ request()->get('person',1) }}</span>
                                        </div>
                                    </li>
                                    <li class="sort-by-rating">
                                        <label for="">&nbsp;</label>
                                        <div class="form-group">
                                            <button class="btn-medium uppercase"><i class="fa fa-search"></i></button>
                                        </div>
                                    </li>
                                    <li class="sort-by-name">
                                        <label for="">&nbsp;</label>
                                        <div class="">
                                            <select name="sort" id="orderby">
                                                <option value="">Sırala</option>
                                                <option value="price" data-sort="asc">Fiyat Artan</option>
                                                <option value="price" data-sort="desc">Fiyat Azalan</option>
                                                <option value="created_at" data-sort="desc">Yeni</option>
                                                <option value="point" data-sort="desc">Puan</option>
                                                <option value="view_count" data-sort="desc">Görüntüleme</option>
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <div class="hotel-list listing-style3 hotel" id="villaContainer">
                            @include('site.service.partials.pagination_data')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    {{--    <script src="/site/modules/pagination.js"></script>--}}

    <script src="/js/pages/app.services.js"></script>
@endsection
