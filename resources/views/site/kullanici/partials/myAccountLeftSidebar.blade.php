<ul class="tabs">
    @php
        $rows[\App\Models\Auth\Role::ROLE_STORE] = [
            ['title' => __('panel.navbar.account'),'route' => 'user.dashboard','icon' => 'soap-icon-list circle'],
            [
                'title' => __('panel.navbar.reservations'),
                'route' => 'user.reservations.index',
                'icon' => 'soap-icon-businessbag circle',
                'routes' => ['user.reservations.index','user.reservations.show']

            ],
            ['title' => __('panel.navbar.services'),'route' => 'user.services.index','icon' => 'soap-icon-businessbag circle','routes' => ['user.services.index','user.services.create','user.services.edit']],
            ['title' => __('panel.navbar.messages'),'route' => 'user.chat.index','icon' => 'soap-icon-generalmessage circle','routes' => ['user.chat.index']],
            ['title' => __('panel.navbar.comments'),'route' => 'user.comments.index','icon' => 'soap-icon-comment circle'],
            ['title' => __('panel.navbar.packages'),'route' => 'user.packages.index','icon' => 'fa fa-archive','routes' => ['user.packages.show','user.packages.index']],
            ['title' => __('panel.navbar.profil'),'route' => 'user.detail','icon' => 'soap-icon-user circle'],
        ];
        $rows[\App\Models\Auth\Role::ROLE_CUSTOMER] = [
              ['title' => __('panel.navbar.account'),'route' => 'user.customer.dashboard','icon' => 'soap-icon-list circle'],
                [
                    'title' => __('panel.navbar.reservations'),
                    'route' => 'user.reservations.index',
                    'icon' => 'soap-icon-businessbag circle',
                    'routes' => ['user.reservations.index','user.reservations.show']

                ],
                ['title' => __('panel.navbar.messages'),'route' => 'user.chat.index','icon' => 'soap-icon-generalmessage circle','routes' => ['user.chat.index']],
                ['title' => __('panel.navbar.favorites'),'route' => 'user.favorites','icon' => 'soap-icon-wishlist circle'],
                // ['title' => __('panel.navbar.comments'),'route' => 'user.comments.index','icon' => 'soap-icon-comment circle'],
                ['title' => __('panel.navbar.profil'),'route' => 'user.detail','icon' => 'soap-icon-user circle'],
        ];
    @endphp
    @foreach($rows[$loggedUser->role_id] as $row)
        <li class="{{ Request::routeIs($row['routes'] ?? $row['route']) ? 'active':'' }}">
            <a href="{{ route($row['route']) }}">
                <i class="{{ $row['icon'] }}"></i>{{ $row['title'] }}
                @if($row['route'] == 'user.chat.index' and $unReadMessageCount )
                    ({{ $unReadMessageCount }})
                @endif
            </a>
        </li>
    @endforeach
    <li>
        <form action="{{ route('user.logout') }}" id="logoutForm" method="POST">
            @csrf
            @method('DELETE')
        </form>
        <a href="javascript:document.getElementById('logoutForm').submit()"><i
                class="soap-icon-close circle"></i>{{ __('panel.navbar.logout') }}</a>
    </li>

</ul>
