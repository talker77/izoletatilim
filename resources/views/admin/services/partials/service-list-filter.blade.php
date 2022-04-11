<!-- filtreleme -->
<div class="box box-default">
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <form action="{{ route('admin.services') }}" method="GET" id="form">
                <div class="col-md-12">
                    <div class="col-md-1" style="padding-top: 8px"><strong>Filtrele : </strong></div>
                    @if(config('admin.product.use_companies'))
                        <div class="col-md-2">
                            <select name="company" class="form-control" id="company">
                                <option value="">--@lang('admin.company') seçiniz --</option>
                                @foreach($companies as $com)
                                    <option value="{{ $com->id }}" {{ request('company') == $com->id ? 'selected' : '' }}>{{ $com->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-2">
                        <select name="status" class="form-control" id="status">
                            <option value="">--Durum seçiniz --</option>
                            @foreach([\App\Models\Service::STATUS_PASSIVE,\App\Models\Service::STATUS_PENDING_APPROVAL,\App\Models\Service::STATUS_PUBLISHED,\App\Models\Service::STATUS_REJECTED] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ __('admin.service_statues.'.$status) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="serviceType" class="form-control" id="serviceTypeFilter">
                            <option value="">--İlan Tipi Seçiniz--</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ $type->id == request('serviceType') ? 'selected': '' }}> {{ $type->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <select name="type" class="form-control" id="typeFilter">
                            <option value="">--Tür Seçiniz--</option>
                            @foreach(\App\Models\Service::storeTypes() as $storeType)
                                <option value="{{ $storeType[0] }}" {{ $storeType[0] == request('type') ? 'selected': '' }}> {{ $storeType[1] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="country" class="form-control" id="countryFilter">
                            <option value="">--Ülke Seçiniz--</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ $country->id == request('country') ? 'selected': '' }}> {{ $country->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-sm btn-success">Filtrele</button>
                        <a href="{{ route('admin.services') }}" class="btn btn-sm btn-danger">Temizle</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
