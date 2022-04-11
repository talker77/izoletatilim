<?php

return [
    'navbar' => [
        'account' => 'Hesabım',
        'reservations' => 'Rezervasyonlarım',
        'messages' => 'Mesajlar',
        'services' => 'İlanlarım',
        'favorites' => 'Favorilerim',
        'comments' => 'Yorumlar',
        'profil' => 'Profil',
        'logout' => 'Çıkış',
        'packages' => 'Paketler',
    ],
    'reservation' => 'Rezervasyon',
    'service' => 'İlan',
    'appointments' => 'Randevular',
    'appointment' => 'Randevu',
    'buy_package' => 'Paket Satın Al',
    'reservations' => [
        'filters' => [
            'serviceId' => 'İlan',
            'status' => 'Durum'
        ],
        'already_verified' => 'Rezervasyon zaten onaylandı.',
        'already_canceled' => 'Rezervasyon zaten iptal edildi.',
        'reservation_email_verified_please_wait_for_approve' => 'Rezervasyon talebiniz alınmıştır ilan sahibi sizinle iletişime geçecektir. Lütfen sahibi tarafından onaylanmasını bekleyin.Size mail ile kısa sürede bildireceğiz.',
        'help' => [
            'list' => [
                \App\Models\Auth\Role::ROLE_STORE => 'Kullanıcıların verdiğiniz ilanlardan aldıkları rezervasyonlar aşağıda listelenir.',
                \App\Models\Auth\Role::ROLE_CUSTOMER => 'Almış olduğunuz tüm rezervasyonlar burada listelenir',
            ]
        ],
    ],

    // DASHBOARD
    'dashboard' => [
        'Villa' => [
            'icon' => 'icon soap-icon-hotel',
            'color' => 'fact blue'
        ],
        'Karavan' => [
            'icon' => 'icon soap-icon-car',
            'color' => 'fact yellow'
        ],
    ],
    // DASHBOARD RESERVATIONS
    'reservation_status' => [
        'title' => [
            \App\Models\Reservation::STATUS_EMAIL_ONAY_BEKLIYOR => "Email Onayı Bekliyor",
            \App\Models\Reservation::STATUS_EMAIL_ONAYLANDI => "Email Onaylandı",
            \App\Models\Reservation::STATUS_ONAY_BEKLIYOR => "Onay Bekliyor",
            \App\Models\Reservation::STATUS_ONAYLANDI => "Onaylandı",
            \App\Models\Reservation::STATUS_RED => "Onaylanmadı",
            \App\Models\Reservation::STATUS_IPTAL => "İptal Edildi",
            \App\Models\Reservation::STATUS_SURE_DOLDU => "Süre Doldu",
        ],
        'icon' => [
            \App\Models\Reservation::STATUS_EMAIL_ONAY_BEKLIYOR => 'soap-icon-clock icon',
            \App\Models\Reservation::STATUS_ONAY_BEKLIYOR => 'soap-icon-clock icon',
            \App\Models\Reservation::STATUS_ONAYLANDI => 'soap-icon-insurance icon',
            \App\Models\Reservation::STATUS_RED => 'soap-icon-restricted icon',
            \App\Models\Reservation::STATUS_IPTAL => 'soap-icon-close icon',
            \App\Models\Reservation::STATUS_SURE_DOLDU => 'soap-icon-close icon',
        ],
        'color' => [
            \App\Models\Reservation::STATUS_EMAIL_ONAY_BEKLIYOR => 'yellow',
            \App\Models\Reservation::STATUS_ONAY_BEKLIYOR => 'yellow',
            \App\Models\Reservation::STATUS_ONAYLANDI => 'green',
            \App\Models\Reservation::STATUS_RED => 'red',
            \App\Models\Reservation::STATUS_IPTAL => 'red',
            \App\Models\Reservation::STATUS_SURE_DOLDU => 'red',
        ],
        \App\Models\Auth\Role::ROLE_STORE => [
            'description' => [
                \App\Models\Reservation::STATUS_EMAIL_ONAY_BEKLIYOR => "Rezervasyon kullanıcı tarafından oluşturuldu. Kullanıcının emaili onaylaması bekleniyor.",
                \App\Models\Reservation::STATUS_EMAIL_ONAYLANDI => "Rezervasyon email yoluyla kullanıcı tarafından onaylandı.Tamamlamak için onaylamanız gerekmektedir.",
                \App\Models\Reservation::STATUS_ONAY_BEKLIYOR => "Rezervasyon email yoluyla kullanıcı tarafından onaylandı.Tamamlamak için onaylamanız gerekmektedir.",
                \App\Models\Reservation::STATUS_ONAYLANDI => "Rezervasyon onaylandı.",
                \App\Models\Reservation::STATUS_RED => "Rezervasyonu iptal ettiniz.",
                \App\Models\Reservation::STATUS_IPTAL => "Rezervasyon kullanıcı tarafından iptal edildi.",
                \App\Models\Reservation::STATUS_SURE_DOLDU => "Rezervasyon belirlenen süre içinde kullanıcı tarafından onaylanmadığı içi iptal edildi.",
            ],
        ],
        \App\Models\Auth\Role::ROLE_CUSTOMER => [
            'description' => [
                \App\Models\Reservation::STATUS_EMAIL_ONAY_BEKLIYOR => "Rezervasyon oluşturuldu. Rezervasyonu onaylamak için lütfen mail adresinizi kontrol ediniz.",
                \App\Models\Reservation::STATUS_EMAIL_ONAYLANDI => "Rezervasyonu email yoluyla onayladınız.İlan sahibi tarafından onaylandıktan sonra size mail olarak bildirilecektir.",
                \App\Models\Reservation::STATUS_ONAY_BEKLIYOR => "Rezervasyonu email yoluyla onayladınız.İlan sahibi tarafından onaylandıktan sonra size mail olarak bildirilecektir.",
                \App\Models\Reservation::STATUS_ONAYLANDI => "Rezervasyon onaylandı.",
                \App\Models\Reservation::STATUS_RED => "Rezervasyon sahibi tarafından iptal edildi.",
                \App\Models\Reservation::STATUS_IPTAL => "Rezervasyonu iptal ettiniz.",
                \App\Models\Reservation::STATUS_SURE_DOLDU => "Rezervasyonu belirlenen süre içerisinde onaylamadığınız için iptal edildi.",
            ]
        ],
    ],

    // Notifications
    'notifications' => [
        'keys' => [
            'created_at' => 'Oluşturulma Tarihi',
            'start_date' => 'Giriş',
            'end_date' => 'Çıkış',
            'day_count' => 'Gün Sayısı',
            'total_price' => 'Toplam Tutar',
            'service_title' => 'İlan Başlık',
            'service_id' => 'İlan ID',
            'service_address' => 'İlan Address',
            'service_slug' => 'İlan URL',
            'user' => 'Kullanıcı',
            'price_per_day' => 'Fiyat (Gün)',
            'user_email' => 'Müşteri Email',
            'user_full_name' => 'Müşteri',
            'reservation_id' => 'Rezervasyon Id',
        ],
        'App\Notifications\Reservation\ReservationCancelledFromClientNotification' => [
            'title' => 'Rezervasyon kullanıcı tarafından iptal edildi.',
            'description' => 'Aşağıda bilgileri verilen rezervasyon kullanıcı tarafından iptal edildi.',
            'icon' => 'fa fa-user-times takeoff-effect red-bg',
        ],
        'App\Notifications\Reservation\PendingReservationRequestNotification' => [
            'title' => 'Onay bekleyen rezervasyonun var.',
            'icon' => 'fas fa-clock takeoff-effect yellow-bg',
            'description' => "<b> :user_full_name </b> tarafından <b>:service_title</b> için :start_date - :end_date tarihleri arasında rezervasyon talebi aldınız. Onaylamak veya iptal etmek için lütfen rezervasyonlarım kısmından işlem yapınız."
        ],
        'App\Notifications\Reservation\ReservationApproved' => [
            'title' => 'Rezervasyon isteğin onaylandı.',
            'icon' => 'fa fa-check-circle takeoff-effect green-bg',
            'description' => "<b> :service_title </b> için :start_date - :end_date arasında oluşturduğun rezervasyon ilan sahibi tarafından onaylandı."
        ],
        'App\Notifications\Reservation\ReservationRejected' => [
            'title' => 'Rezervasyon isteğin reddedildi.',
            'icon' => 'fa fa-times takeoff-effect red-bg',
            'description' => "<b> :service_title </b> için :start_date - :end_date arasında oluşturduğun rezervasyon talebi sahibi tarafından reddedildi."
        ],
        'App\Notifications\Reservation\VerifyReservationNotification' => [
            'title' => 'Rezervasyon için email onayı gerekiyor.',
            'icon' => 'fas fa-clock takeoff-effect yellow-bg',
            'description' => "<b> :service_title </b> için :start_date - :end_date tarihleri arasında oluşturduğun rezervasyon için size gönderilen emaili doğrulamanız gerekiyor."
        ],
        'App\Notifications\Reservation\ReservationMailVerifiedNotification' => [
            'title' => 'Email başarıyla onaylandı.',
            'icon' => 'far fa-envelope-open takeoff-effect green-bg',
            'description' => "<b> :service_title </b> için :start_date - :end_date tarihleri arasında oluşturduğun rezervasyon için size gönderilen emaili doğruladınız. İlan sahibi onayından sonra size email olarak bildirilecektir."
        ],
        'App\Notifications\Service\ServiceApproved' => [
            'title' => 'İlan Onaylandı',
            'icon' => 'fa fa-check takeoff-effect green-bg',
            'description' => "<b>:service_title </b> ilanın onaylandı."
        ],
        'App\Notifications\Service\ServiceRejected' => [
            'title' => 'İlan Onaylanmadı',
            'icon' => 'fa fa-times takeoff-effect red-bg',
            'description' => "<b>:service_title </b> ilanın onaylanmadı."
        ]
    ],

    // Services
    'service_status' => [
        \App\Models\Service::STATUS_PASSIVE => [
            'title' => 'İlan pasif duruma getirildi.',
            'short_title' => 'Pasif',
            'desc' => 'İlan yönetici tarafından pasif hale getirildi.',
            'class' => 'alert-danger-cs'
        ],
        \App\Models\Service::STATUS_PENDING_APPROVAL => [
            'title' => 'Onay Bekliyor',
            'short_title' => 'Onay Bekliyor',
            'desc' => 'İlanın yönetici tarafından onaylanması bekleniyor.',
            'class' => 'alert-warning-cs'
        ],
        \App\Models\Service::STATUS_REJECTED => [
            'title' => 'Reddedildi',
            'short_title' => 'Reddedildi',
            'desc' => 'İlan yönetici tarafından reddedildi. Lütfen tüm bilgilerin eksiksiz ve doğru olduğundan emin olduktan sonra tekrar kaydediniz.',
            'class' => 'alert-danger-cs'
        ],
        \App\Models\Service::STATUS_REQUIRE_ACTIVE_APPOINTMENT => [
            'title' => 'Rezervasyon Eklenmesi Gerekiyor',
            'short_title' => 'Rezervasyon Eklenmesi Gerekiyor',
            'desc' => 'İlanın onaya gönderilmesi için başlangıç tarihi bugün veya bugünden büyük en az 1 adet aktif olan rezervasyon tarih aralıkları eklemeniz gerekiyor. "Rezervasyon ve Fiyat listesi" bölümünden yeni tarih ekleyebilirsiiz.',
            'class' => 'alert-warning-cs'
        ],
        \App\Models\Service::STATUS_PUBLISHED => [
            'title' => 'Onaylandı',
            'short_title' => 'İlan yayında',
            'desc' => 'İlan yayında.',
            'class' => 'alert-success-cs'
        ],
    ]
];

