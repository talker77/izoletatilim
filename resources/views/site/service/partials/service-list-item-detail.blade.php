<div class="tab-container style1">
    <ul class="tabs " style="align-items: center;">
        <li class="active"><a href="#unlimited-layouts-{{ $item->id }}" data-toggle="tab">Genel Bakış</a></li>
        <li><a href="#design-inovation-{{ $item->id }}" data-toggle="tab">Fotograflar</a></li>
        <li><a href="#best-support-{{ $item->id }}" data-toggle="tab">Yorumlar</a></li>
        <li><a href="#8-sliders-{{ $item->id }}" data-toggle="tab">Bilgi</a></li>
        <li><a href="#8-sell-{{ $item->id }}" data-toggle="tab">Fiyatlar</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="unlimited-layouts-{{ $item->id }}">
            {{--            @if (count($item->images))--}}
            <div class="items-container isotope image-box style9 row">

                @foreach($item->images->take(3) as $image)
                    <div class="iso-item col-xs-12 col-sms-6 col-sm-6 col-md-3 ">
                        <article class="box">
                            <figure>
                                <a class="hover-effect popup-gallery" title="" href="{{ route('services.gallery',['slug' => $item->slug]) }}"><img width="270" height="160" alt="" src="{{ imageUrl('public/service-gallery',$image->title) }}"></a>
                            </figure>
                        </article>
                    </div>
                @endforeach
                <div class="iso-item col-xs-12 col-sms-6 col-sm-6 col-md-3 ">
                    <article class="box">
                        <figure>
                            <a class="hover-effect popup-gallery" title="" href="{{ route('services.gallery',['slug' => $item->slug]) }}">
                                <img width="270" height="160" alt="" src="{{ imageUrl('public/services',$item->image) }}">
                            </a>
                        </figure>
                    </article>
                </div>
            </div>
            <div style="float: right;margin-top: -40px">
                <a class="button btn-small white popup-gallery" href="{{ route('services.gallery',['slug' => $item->slug]) }}" style=" border: 1px solid black;">Diger resimler
                    <i class="soap-icon-right" style="position: absolute;font-size: 15px;font-weight: 700;padding-left: 5px;"></i>
                </a>
            </div>
            {{--            @endif--}}

            <div class="row appointments">
                @foreach($appointments as $appointment)
                    <a href="{{ route('services.forward') }}?redirectTo={{ $appointment->service_company->redirect_to }}&companyId={{ $appointment->service_company->company_id }}&serviceCompanyId={{ $appointment->service_company_id }}" target="_blank" class="redirect_to">
                        <div class="col-sm-3">
                            <div class="pricing-table white box list-item-border">
                                <div class="header clearfix mt-30">
                                    <h4 class="box-title" style="margin-bottom: 0px"><span>Önerilen Fiyat<small></small></span></h4>
                                    <span class="sub-text company_name">{{ $appointment->service_company->company ? $appointment->service_company->company->title : '' }}</span>
                                </div>
                                <p class="description">
                                    <span class="price"><span class="appointmentPrice">{{ $appointment->price }}</span> ₺<small> / gece</small></span>
                                    &nbsp;
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
                @if ($item->attributes->count())
                    <div class="col-sm-12">
                        <h3 class="box-title col-md-12" style="margin-bottom: 25px">Oteldeki özellikler</h3>
                        <ul class="amenities clearfix style2 pull-left">
                            @foreach($item->attributes->whereNotNull('icon') as $attribute)
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style2"><i class="{{ $attribute->icon }} circle"></i>{{ $attribute->title }}</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="tab-pane fade" id="design-inovation-{{ $item->id }}">
            <div class="items-container isotope image-box style9 row">

                @foreach($item->images as $image)
                    <div class="iso-item col-xs-12 col-sms-6 col-sm-6 col-md-3 ">
                        <article class="box">
                            <figure>
                                <a class="hover-effect popup-gallery" title="" href="{{ route('services.gallery',['slug' => $item->slug]) }}">
                                    <img width="270" height="160" alt="" src="{{ imageUrl('public/service-gallery',$image->title) }}">
                                </a>
                            </figure>
                        </article>
                    </div>
                @endforeach
                    <div class="iso-item col-xs-12 col-sms-6 col-sm-6 col-md-3 ">
                        <article class="box">
                            <figure>
                                <a class="hover-effect popup-gallery" title="" href="{{ route('services.gallery',['slug' => $item->slug]) }}">
                                    <img width="270" height="160" alt="" src="{{ imageUrl('public/services',$item->image) }}">
                                </a>
                            </figure>
                        </article>
                    </div>

            </div>
        </div>
        <div class="tab-pane fade" id="best-support-{{ $item->id }}">
            <div class="about-author block">
                @foreach($item->last_active_company_comments as $comment)
                    <div class="about-author-container">
                        <div class="about-author-content">
                            <div class="avatar">
                                <span class="skor2" style="{{ commentColor($comment->point) }}">{{ $comment->point }}</span><br>
                                <p> Kullanıcı Yorum tarihi: {{ createdAt($comment->created_at) }}</p>
                            </div>
                            <div class="description">
                                <h4><a href="#">{{ $comment->full_name }}</a></h4>
                                <div class="five-stars-container">
                                    <span class="five-stars" style="width: {{ $comment->point * 10 }}%;"></span>
                                </div>
                                <p>{{ $comment->message }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="tab-pane fade" id="8-sliders-{{ $item->id }}">
            <h3 class="box-title" style="margin-bottom: 25px">{{ $item->title }}</h3>
            <iframe
                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                frameborder="0"
                scrolling="no"
                marginheight="0"
                marginwidth="0"
                src="https://maps.google.com/maps?q={{ $item->lat }},{{ $item->long }}&hl=tr&z=14&amp;output=embed"
            >
            </iframe>

            @if ($item->attributes->count())
                <h3 class="box-title" style="margin-bottom: 25px">En İyi Özellikler</h3>
                <div class="row block add-clearfix">
                    @foreach($item->attributes->whereNotNull('icon') as $attribute)
                        <div class='col-xs-6 col-sm-3 col-md-3'>
                            <span class="icon-box style2"><i class="{{ $attribute->icon }} circle"></i>{{ $attribute->title }}</span>
                        </div>
                    @endforeach

                </div>
            @endif

        </div>
        <div class="tab-pane fade" id="8-sell-{{ $item->id }}">
            @foreach($appointments as $appointment)
                <a href="{{ $appointment->service_company->redirect_to }}" target="_blank" class="redirect_to">
                    <div class="col-sm-3">
                        <div class="pricing-table white box list-item-border">
                            <div class="header clearfix mt-30">
                                <h4 class="box-title" style="margin-bottom: 0px"><span>Önerilen Fiyat<small></small></span></h4>
                                <span class="sub-text company_name">{{ $appointment->service_company->company ? $appointment->service_company->company->title : '' }}</span>
                            </div>
                            <p class="description">
                                <span class="price"><span class="appointmentPrice">{{ $appointment->price }}</span> ₺<small> / gece</small></span>
                                &nbsp;
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
