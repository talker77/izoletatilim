<div class="photo-gallery style1" id="photo-gallery1" data-animation="slide" data-sync="#image-carousel1">
    <ul class="slides">
        <li><img src="/storage/services/{{ $item->image }}" alt="" /></li>
        @foreach($item->images as $image)
            <li><img src="/storage/service-gallery/{{ $image->title }}" alt="" /></li>
        @endforeach
    </ul>
</div>
<div class="image-carousel style1" id="image-carousel1" data-animation="slide" data-item-width="70" data-item-margin="10" data-sync="#photo-gallery1">
    <ul class="slides">
        <li><img src="/storage/services/{{ $item->image }}" alt="" /></li>
        @foreach($item->images as $image)
            <li><img src="/storage/service-gallery/{{ $image->title }}" alt="" /></li>
        @endforeach
    </ul>
</div>
