@if ($item->id)
    @if($item->store_type == \App\Models\Service::STORE_TYPE_LOCAL)
        @include('admin.services.partials.create-service-appointment-modal')

        <!-- Update Modal -->
        <div id="serviceAppointmentUpdateModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Rezervasyon Güncelle</h4>
                    </div>
                    <div class="detail">
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.appointments')</h3>
                    <div class="box-tools">
                        <a href="" title="Rezervasyon ekle" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i></a>
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
                            <th>@lang('admin.created_at')</th>
                            <th>#</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    @elseif ($adUser->role_id == \App\Models\Auth\Role::ROLE_SUPER_ADMIN)
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.appointments')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="table-appointments">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>@lang('admin.navbar.company_service') <i class="fa fa-external-link"></i></th>
                            <th>@lang('admin.company') <i class="fa fa-external-link"></i></th>
                            <th>Başlangıc</th>
                            <th>Bitiş</th>
                            <th>Fiyat/Gece</th>
                            <th>Durum</th>
                            <th>@lang('admin.created_at')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endif
