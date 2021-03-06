<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">@lang('admin.services_gallery')</h3>
                <div class="box-tools">
                    <label for="">@lang('admin.images')</label>
                    <input type="file" name="imageGallery[]" multiple>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    @foreach($item->images as $image)
                        <div class="col-md-2" id="productImageCartItem{{$image->id}}">
                            <div class="card">
                                <div class="card-body">
                                    <a href="javascript:void(0);" onclick="deleteImage({{ $image->id }})" class="btn btn-danger btn-xs pull-right">X</a>
                                    <a target="_blank" href="{{ imageUrl('public/service-gallery',$image->title) }}">
                                        <img src="{{ imageUrl('public/service-gallery',$image->title) }}" height="170" width="170"
                                             class="card-img-top" style="width: 100%"
                                             alt="...">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
