@extends('site.layouts.base')
@section('title',$category->title.'-'.$site->title)
@section('header')
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{$category->title}} | {{ $site->title }}</title>
    <meta name="description"
          content="{{ is_null($category->spot) ?  $category->title .' kategorisinde bulunan yüzlerce '.$category->title. ' ürünlerine ulaşabilir birbirinden güzel indirimlerle '.$category->title. ' ürünlerine sahip olabilirsiniz' : $category->spot }}"/>
    <meta name="keywords" content="{{ $category->title.','.@$data['products'][0]->title.','.@$data['products'][1]->title }}"/>
    <meta property="og:type" content="product"/>
    <meta property="og:url" content="{{ route('category.detail',$category->slug)  }}"/>
    <meta property="og:title" content="{{ $category->title .' | '. $site->title }}"/>
    <meta property="og:image" content="{{ $site->domain }}/uploads/products/{{ @$data['products'][0]->image }}"/>
    <meta name="twitter:card" content="product"/>
    <meta name="twitter:site" content="@siteadi"/>
    <meta name="twitter:creator" content="@siteadi"/>
    <meta name="twitter:title" content="{{ $category->title .' | '. $site->title }}"/>
    <meta name="twitter:description" content="{{ $category->title }} {{ $category->spot }}"/>
    <meta name="twitter:image:src" content="{{ $site->domain }}/uploads/products/{{ @$data['products'][0]->image }}"/>
    <meta name="twitter:domain" content="{{$site->domain}}"/>
    <link rel="canonical" href="{{ route('product.detail',$category->slug)  }}"/>
@endsection
@section('content')
    <input type="hidden" id="hdnCatName" value="{{ $category->title  }}">
    <input type="hidden" id="hdnCatSlug" value="{{ $category->slug }}">
    <input type="hidden" id="hdnCurPage" value="{{ request('page',1) }}">
    <input type="hidden" id="hdnTotalPage" value="{{ $data['totalPage'] }}">
    {{--    <input type="hidden" id="pageTrigger" value="False">--}}
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                @if($category->parent_cat ? $category->parent_cat->slug : null)
                    <li class="breadcrumb-item"><a
                            href="{{ route('category.detail',$category->parent_cat->slug != null ? $category->parent_cat->slug: '#' ) }}">{{ $category->parent_cat->title }}</a></li>
                @else
                    <li class="breadcrumb-item">Kategori</li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{$category->title}}</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <nav class="toolbox">
                    <div class="toolbox-left">
                        <div class="toolbox-item toolbox-sort">
                            <div class="select-custom">
                                <select name="orderby" id="orderby" class="form-control">
                                    <option value="">---Sırala---</option>
                                    <option value="yeni">Yeni Ürünler</option>
                                    <option value="artanfiyat">Artan Fiyat</option>
                                    <option value="azalanfiyat">Azalan Fiyat</option>
                                </select>
                            </div><!-- End .select-custom -->

                        </div><!-- End .toolbox-item -->
                    </div><!-- End .toolbox-left -->

                    <div class="toolbox-item toolbox-show">
                        <label><span class="spTotalProduct">{{ $data['productTotalCount'] }}</span> sonuçtan <span
                                class="spRangePageItems">0-{{ \App\Models\Product\Urun::PER_PAGE  }}</span> gösteriliyor</label>
                    </div><!-- End .toolbox-item -->
                </nav>

                <div class="row row-sm" id="productContainer">
                    @foreach($data['products'] as $product)
                        <div class="col-6 col-md-4 col-xl-3">
                            <div class="product-default">
                                <figure>
                                    <a href="{{ route('product.detail',$product->slug) }}">
                                        <img style="height: 200px;width: 250px" src="{{ config('constants.image_paths.product270x250_folder_path').''.$product->image }}">
                                    </a>
                                </figure>
                                <div class="product-details">
                                    <h2 class="product-title">
                                        <a href="{{ route('product.detail',$product->slug) }}" title="{{$product->title}}">{{substr($product->title,0,25)}}</a>
                                    </h2>
                                    <div class="price-box">
                                        @if($product->current_discount_price)
                                            <span class="old-price" title="ürün fiyatı">  {{$product->current_price }} {{ $product->current_symbol }}</span>
                                            <span class="product-price">  {{$product->current_discount_price}} {{ $product->current_symbol }}</span>
                                        @else
                                            <span class="product-price" title="ürün fiyatı">  {{$product->current_price }} {{ $product->current_symbol }}</span>
                                        @endif

                                    </div><!-- End .price-box -->
                                    <div class="product-action">
                                        <a href="javascript:void(0);" class="btn-icon-wish"><i class="icon-heart" onclick="return addToFavorites({{$product->id}})"></i></a>
                                        <a class="btn-icon btn-add-cart" data-toggle="modal" data-target="#addCartModal"
                                           onclick="return addItemToBasket({{$product->id}},{{ count($product->detail) > 0 ? 1: 0 }})"><i
                                                class="icon-bag"></i>Sepete Ekle</a>
                                        <a href="{{route('product.quickView',$product->slug)}}" class="btn-quickview" title="Önizleme" id="productQuickView{{$product->id}}"><i
                                                class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </div><!-- End .product-details -->
                            </div>
                        </div>
                    @endforeach
                </div>

                <nav class="toolbox toolbox-pagination">
                    <div class="toolbox-item toolbox-show">
                        <label><span class="spTotalProduct">{{ $data['productTotalCount'] }}</span> sonuçtan <span
                                class="spRangePageItems">0-{{ \App\Models\Product\Urun::PER_PAGE  }}</span> gösteriliyor</label>
                    </div><!-- End .toolbox-item -->

                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link page-link-btn" id="btnPrekategori.blade.phpvPage" href="javascript:void(0);" onclick="return pagination('prev')"><i class="icon-angle-left"></i></a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#"><span class="spCurPage">1</span> / <span
                                    class="spTotalPage">{{ $data['totalPage'] }}</span></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link page-link-btn" id="btnNextPage" href="javascript:void(0);" onclick="return pagination('next')"><i class="icon-angle-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div><!-- End .col-lg-9 -->

            @include('site.urun.partials.productListLeftSidebar')
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-5"></div><!-- margin -->
@endsection
@section('footer')
    <script src="{{ asset('js/siteProductListFilter.js') }}"></script>
@endsection
