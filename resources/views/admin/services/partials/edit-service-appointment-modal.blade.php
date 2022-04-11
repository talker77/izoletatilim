<form action="{{ route('admin.services.appointments.update',['serviceAppointment' => $item->id]) }}" method="POST">
    @method('PUT')
    <div class="modal-body">
        @csrf
        <div class="form-group col-md-6">
            <label for="email">Başlangıç Tarihi</label>
            <input type="date" class="form-control" name="start_date" required value="{{ $item['start_date'] }}">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Bitiş Tarihi</label>
            <input type="date" class="form-control" name="end_date" required value="{{ $item->end_date }}">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Fiyat/Gece</label>
            <input type="number" step="any" class="form-control" name="price" required value="{{  $item->price  }}">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Durum</label><br>
            <input type="checkbox" name="status" {{ $item->status ? 'checked'  :'' }}>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
        <button type="submit" class="btn btn-success">Kaydet</button>
    </div>
</form>

