<!-- filtreleme -->
<div class="box box-default">
    <div class="box-body" >
        <div class="row">
            <form action="{{ route('admin.services.company.list') }}" method="GET" id="form">
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
                        <input type="date" name="startDate" id="startDate" class="form-control" value="{{ request()->get('startDate') }}">
                        <span class="help-block text-sm">Giriş</span>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="endDate" id="endDate" class="form-control" value="{{ request()->get('endDate') }}">
                        <span class="help-block text-sm">Çıkış</span>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-sm btn-success">Filtrele</button>
                        <a href="{{ route('admin.services.company.list') }}" class="btn btn-sm btn-danger">Temizle</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
