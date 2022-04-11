<!-- excel import modal -->
<div id="excelImport" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="{{ route('user.services.import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Excel ile toplu @lang('panel.service') ekleme</h4>
                </div>
                <div class="modal-body">
                    <p>Aşağıda bulunan örnek excel şemasını bilgisisayarınıza indirip istenilen alanları doldurduktan
                        sonra
                        sisteme toplu şekilde @lang('panel.service') yükleme yapabilirsiniz.</p>

                    <div class="row">
                        <div class="col-md-6">
                            <input type="file" name="services"><br>
                        </div>
                        <div class="col-md-6 ">
                            <button type="submit" class="btn btn-success pull-right" >Yükle</button>
                        </div>
                    </div>


                    <p><b>Örnek Dosya : </b>
                        <a download="" class="blue" style="color: #337ab7" href="/uploads/files/services/services.xlsx"><b>@lang('panel.navbar.services')
                                .xlsx</b></a>

                    </p>

                    <h2>Excel Alanlar</h2>
                    <p>Excel dosyasındaki tüm alanlar için detaylı açıklamalar aşağıda belirtilmiştir.</p>
                    <table class="table">
                        <tbody>
                        @php
                            $serviceTypes = \App\Models\ServiceType::where(['status' => 1])->get()->pluck('title')->toArray();
                            $serviceAttributes = \App\Models\ServiceAttribute::where(['status' => 1])->get()->pluck('title')->toArray();
                            $fields = [
                                [
                                  'column' => 'Başlık',
                                  'description' => 'Hizmet Başlık'
                                ],
                                 [
                                  'column' => 'Adres',
                                  'description' => 'Hizmet detaylı adres bilgisi'
                                 ],
                                  [
                                  'column' => 'Tip',
                                  'description' => 'Hizmet tipi geçerli olanlar (sadece bir tip yazınız) : <br>-' . implode('<br>-',$serviceTypes)
                                 ],
                                 [
                                  'column' => 'Durum',
                                  'description' => 'Yayında mı ? Evet ise = 1, Hayır ise = 0'
                                 ],
                                  [
                                  'column' => 'Ülke',
                                  'description' => 'Ülke Adı Örnek : Türkiye'
                                 ],
                                   [
                                  'column' => 'Şehir',
                                  'description' => 'Şehir Adı Örnek : İstanbul'
                                 ],
                                 [
                                  'column' => 'İlçe',
                                  'description' => 'İlçe Adı Örnek : Kadıköy'
                                 ],
                                    [
                                  'column' => 'Özellikler',
                                  'description' => 'Hizmet Özellik geçerli olanlar  (birden fazla yazılabilir.): <br>-' . implode('---',$serviceAttributes)
                                 ],
                                  [
                                  'column' => 'Gorsel',
                                  'description' => 'Görselin tam yolu ornek http://domain.com/resim-adi.png'
                                 ],
                            ];
                        @endphp
                        @foreach($fields as $field)
                            <tr>
                                <th>{{ $field['column'] }}</th>
                                <td>{!!  $field['description'] !!} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                </div>
            </form>
        </div>

    </div>
</div>
