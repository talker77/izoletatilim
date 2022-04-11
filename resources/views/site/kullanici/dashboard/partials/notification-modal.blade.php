<!-- Modal content -->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">{{ __("panel.notifications.".$notification->type.".title") }}</h4>
</div>
<div class="modal-body">
    <p>{!!  __("panel.notifications.".$notification->type.".description",$notification->data)  !!}</p>
    <table class="table">
        <tbody>
        @foreach($notification['data'] as $key => $value)
            <tr>
                <th>{{ __('panel.notifications.keys.'.$key) }}</th>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
</div>
