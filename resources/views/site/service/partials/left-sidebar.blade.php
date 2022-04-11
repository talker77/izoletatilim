<h4 class="search-results-title"><i class="soap-icon-search"></i><b class="resultCount">{{ $count }}</b> villa bulundu.</h4>
<div class="toggle-container filters-container">
    <div class="panel style1 arrow-right">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#price-filter">Fiyat / Gece</a>
        </h4>
        <div id="price-filter" class="panel-collapse collapse in">
            <div class="panel-content">
                <div id="price-range"></div>
                <br/>
                <span class="min-price-label pull-left"></span>
                <span class="max-price-label pull-right"></span>
                <div class="clearer"></div>
            </div><!-- end content -->
        </div>
    </div>

    <div class="panel style1 arrow-right">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#rating-filter">Misafir Puanı</a>
        </h4>
        <div id="rating-filter" class="panel-collapse filters-container collapse in">
            <div class="panel-content">
                <div id="rating" class="five-stars-container editable-rating"></div>
                <br/>
            </div>
        </div>
    </div>

    <div class="panel style1 arrow-right">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#accomodation-type-filter" class="">Özellikler</a>
        </h4>
        <div id="accomodation-type-filter" class="panel-collapse collapse in">
            <div class="panel-content">
                <ul class="check-square filters-option" id="attributeFilter">
                    @foreach($attributes as $attribute)
                        <li><a href="#" data-id="{{ $attribute->id }}">
                                <i class="{{ $attribute->icon }}"></i>&nbsp;
                                {{ $attribute->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</div>
