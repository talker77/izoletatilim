<div class="panel-group">
    <div class="panel panel-success ">
        <div class="panel-heading ">{{ $currentPackage->package->title }} ( Mevcut
            Paket)
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Paket Adı</th>
                    <th>Kalan Süre</th>
                    <th>Başlangıç</th>
                    <th>Bitiş</th>
                    <th>Toplam Tutar</th>
                    <th>Oluşturulma</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $currentPackage->package->title }}</td>
                    <td>{{ $currentPackage->remaining_day }} Gün</td>
                    <td>{{ createdAt($currentPackage->started_at) }}</td>
                    <td>{{ createdAt($currentPackage->expired_at) }}</td>
                    <td>{{ $currentPackage->price }} ₺</td>
                    <td> {{ createdAt($currentPackage->created_at) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
