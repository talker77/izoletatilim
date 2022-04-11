<h2>Bildirimler</h2>
@forelse($notifications as $notification)
    <a href="javascript:showNotificationContent('{{ $notification->id }}')">
        <div class="icon-box style1 fourty-space" style="{{ $notification->read_at ? 'background-color:white;border:1px solid #dedede7d' : '' }}" >
            <i class="{{ __("panel.notifications.".$notification->type.".icon") }}"></i>
            <span class="time pull-right">{{ $notification->created_at->diffForHumans() }}</span>
            <p class="box-title" >{{ __("panel.notifications.".$notification->type.".title") }}</p>
        </div>
    </a>
@empty
    <p>Henüz bir bildirim yok.</p>
@endforelse


