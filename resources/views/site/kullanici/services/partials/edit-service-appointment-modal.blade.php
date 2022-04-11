<form action="{{ route('user.services.appointments.update',['serviceAppointment' => $item->id]) }}" method="POST" id="modalUpdate" onsubmit="false">
    @method('PUT')
    <div class="modal-body">
        @csrf
        <div class="form-group col-md-6">
            <label for="email">Başlangıç Tarihi</label>
            <input type="date" class="form-control" name="start_date" required value="{{ $item->start_date->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Bitiş Tarihi</label>
            <input type="date" class="form-control" name="end_date" required value="{{ $item->end_date->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Günlük Fiyat</label>
            <input type="number" step="any" class="form-control" name="price" required value="{{  $item->price  }}" min="0">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Aktif/Pasif</label><br>
            <input type="checkbox" name="status" {{ $item->status ? 'checked'  :'' }}>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
        <button type="button" class="btn btn-success btn-update-appointment" data-id="{{ $item->id }}">Kaydet</button>
    </div>
</form>

