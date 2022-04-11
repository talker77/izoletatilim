@foreach($items as $item)
    <article class="box">
        <figure class="col-sm-5 col-md-4">
            <a title="" href="ajax/slideshow-popup.html" class="hover-effect popup-gallery">
                <img width="270" height="160" alt="" src="{{ imageUrl('public/services',$item->image) }}" style="width: 270px;height: 160px">
            </a>
        </figure>
        <div class="details col-sm-7 col-md-8">
            <div>
                <div>
                    <h4 class="box-title">{{ $item->title }}<small><i class="soap-icon-departure yellow-color"></i> {{ $item->title }}</small></h4>
                    <div class="amenities">
                        <i class="soap-icon-wifi circle"></i>
                        <i class="soap-icon-fitnessfacility circle"></i>
                        <i class="soap-icon-fork circle"></i>
                        <i class="soap-icon-television circle"></i>
                    </div>
                </div>
                <div>
                    <div class="five-stars-container">
                        <span class="five-stars" style="width: 80%;"></span>
                    </div>
                    <span class="review">170 reviews</span>
                </div>
            </div>
            <div>
                <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed vitae pulvinar massa idend porta nequetiam elerisque mi id, consectetur adipi deese cing elit maus fringilla bibe endum.</p>
                <div>
                    <span class="price"><small>AVG/NIGHT</small>$1244</span>
                    <a class="button btn-small full-width text-center" title="" href="hotel-detailed.html">SELECT</a>
                </div>
            </div>
        </div>
    </article>
@endforeach
