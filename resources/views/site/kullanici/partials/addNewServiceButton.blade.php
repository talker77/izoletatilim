@if(loggedPanelUser()->isStore())
    <li>&nbsp;<a href="{{ route('user.services.create') }}" class="btn btn-sm btn-primary" style="background-color: #fdb714;color: black"> <i class="fa fa-plus"></i> İlan Ekle</a></li>
@endif
