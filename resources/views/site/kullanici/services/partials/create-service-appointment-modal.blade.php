<!-- Modal -->
<div id="createServiceModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('panel.reservation') Ekle</h4>
            </div>
            <form action="#" method="POST" id="createServiceAppointmentForm" onsubmit="return false;">
                <div class="modal-body">
                    @csrf
                    <div class="person-information">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-6">
                                <x-site.input name="start_date" label="Başlangıç" width="3" type="date"
                                              :value="old('start_date')" required :min="now()->format('Y-m-d')"
                                              class="input-text full-width"/>
                            </div>
                            <div class="col-sm-12 col-md-6 ">
                                <x-site.input name="end_date" label="Bitiş" width="3" type="date"
                                              :value="old('end_date')" required :min="date('Y-m-d',strtotime('+1 day'))"
                                              class="input-text full-width"/>
                            </div>
                            <div class="col-sm-12 col-md-6" style="padding-top: 10px">
                                <x-site.input name="price" label="Günlük Fiyat" width="3" type="number"
                                              :value="old('price')" required min="0"
                                              class="input-text full-width"/>
                            </div>
                            <div class="col-sm-12 col-md-6" style="padding-top: 10px">
                                <label for="email">Aktif/Pasif</label>
                                <input type="checkbox" name="status" checked>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-success btn-create-appointment" data-service-id="{{ $item->id }}">Kaydet</button>
                </div>
            </form>
        </div>

    </div>
</div>
