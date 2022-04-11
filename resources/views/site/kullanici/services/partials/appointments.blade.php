@include('site.kullanici.services.partials.create-service-appointment-modal')
<!-- Update Modal -->
<div id="serviceAppointmentUpdateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('panel.reservation') Güncelle</h4>
            </div>
            <div class="detail">
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="box">

        <div class="row">
            <div class="col-md-6">
                <h3>Rezervasyon ve Fiyat listesi <i class="fa fa-question-circle" title="Bu alandan İlan için kiralanabilir tarih aralıklarını ekleyebilirsiniz."></i></h3>
            </div>
            <div class="col-md-6 pull-right text-right" id="serviceBlock">
                <a href="" title="{{ __('panel.reservation') }} ekle" data-toggle="modal"
                   class="btn btn-sm btn-primary"
                   data-target="#createServiceModal">
                    <i class="fa fa-plus-square"></i> &nbsp; Müsaitlik / Fiyat ekle
                </a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered" id="table-service-store-appointments">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Başlangıc</th>
                        <th>Bitiş</th>
                        <th>Fiyat/Gece</th>
                        <th>Durum</th>
                        <th>Güncelleme</th>
                        <th>#</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
