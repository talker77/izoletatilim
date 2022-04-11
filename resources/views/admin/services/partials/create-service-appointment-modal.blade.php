<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Rezervasyon Ekle</h4>
            </div>
            <form action="{{ route('admin.services.appointments.create',['service' => $item->id]) }}" method="POST">
                <div class="modal-body">

                    @csrf
                    <div class="form-group col-md-6">
                        <label for="email">Başlangıç Tarihi</label>
                        <input type="date" class="form-control" name="start_date" required value="{{ old('start_date') }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Bitiş Tarihi</label>
                        <input type="date" class="form-control" name="end_date" required  value="{{ old('end_date') }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Fiyat/Gece</label>
                        <input type="number" step="any" class="form-control" name="price" required  value="{{ old('price') }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Durum</label><br>
                        <input type="checkbox" name="status">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">Kaydet</button>
                </div>
            </form>
        </div>

    </div>
</div>
