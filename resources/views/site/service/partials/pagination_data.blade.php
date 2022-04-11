@forelse($data as $item)
    <article class="box">
        <figure class="col-sm-5 col-md-4">
            <a title="{{ $item->title }}" href="{{ route('services.detail',['slug' => $item->slug]) }}?startDate={{ request('startDate')}}&endDate={{ request('endDate') }}">
                <img width="270" height="160" alt="" src="{{ imageUrl('public/services/thumb',$item->image) }}">
            </a>
        </figure>
        <div class="details col-sm-7 col-md-8">
            <div>
                <div>
                    <a href="{{ route('services.detail',['slug' => $item->slug]) }}?startDate={{ request('startDate')}}&endDate={{ request('endDate') }}">
                        <h4 class="box-title">
                            {{ $item->title  }}<small>{{ $item->type ? $item->type->title : '' }}</small>
                        </h4>
                    </a>
                    <div class="amenities">
                        <a href="javascript:addToFavorites({{ $item->id }})" class="cursor-point">
                            <i class="soap-icon-heart circle cursor-point" title="Favorilere Ekle"></i>
                        </a>
                        <a href="{{ route('services.gallery',['slug' => $item->slug]) }}" class="cursor-point popup-gallery">
                            <i class="soap-icon-photogallery circle cursor-point" title="Favorilere Ekle"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <div class="five-stars-container">
                        <span class="five-stars" style="width: {{ $item->star_percent }}%;"></span>
                    </div>
                    <span class="review"></span>
                </div>
            </div>
            <div>
                <div class="second-row service-attribute-container">
                    <div class="time">
                        <div class="take-off col-sm-4">
                            <div class="icon"><i class="soap-icon-departure yellow-color"></i></div>
                            <div>
                                <span
                                    class="skin-color">{{ $item->district->title }}</span><br>{{ $item->state ? $item->state->title : '' }}
                                -
                                {{$item->country->title}}
                            </div>
                        </div>
                        <div class="landing col-sm-4">
                            <div class="icon"><i class="soap-icon-comment yellow-color"></i></div>
                            <div>
                                <span
                                    class="skin-color">{{ $item->star }}</span><br>{{ $item->active_comments_count }}
                                Yorum
                            </div>
                        </div>
                        <div class="total-time col-sm-4">
                            <div class="icon"><i class="soap-icon-features yellow-color"></i></div>
                            <div>
                                <span
                                    class="skin-color"></span>{{ implode("-",$item->attributes->take(3)->pluck('title')->toArray()) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="price"><small>Fiyat/Gece</small>{{ $item->service_appointments()->latest()->first()->price }} ₺</span>
                </div>
            </div>
        </div>
    </article>
@empty
    <div class="sort-by-section" style="padding:10px 18px;padding-top: 12px">
        <p style="font-size: 14px">Aradığınız kriterlere uygun kayıt bulunamadı.</p>
    </div>
@endforelse
{!! $data->links() !!}


