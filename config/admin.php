<?php

// admin constants
$data = [
    'title' => 'CMS',
    'short_title' => '-',
    'creator' => '-',
    'creator_link' => 'http://google.com',
    'version' => 'v1.0.2',
    'max_upload_size' => 3024,
    'max_service_image_count' => 25,
    // module status
    'module_status' => [
        'banner' => false,
        'blog' => false,
        'coupon' => false,
        'content_management' => false,
        'contact' => false,
        'campaign' => false,
        'e_bulten' => true,
        'gallery' => false,
        'order' => false,
        'cargo' => false,
        'product' => false,
        'log' => true,
        'sss' => false,
        'setting' => true,
        'reference' => false,
        'user' => true,
        'service' => true,
        'our_team' => false,
        'locations' => true,
        'appointment' => true,
        'report' => true,
        'packages' => true,
    ],
    'blog' => [
        'use_tags' => true,
        'use_image' => true,
        'use_language' => false,
        'use_categories' => false
    ],
    'product' => [
        // sub modules
        'use_comment' => true,
        'use_attribute' => true, // product detail ex: color - green
        'use_category' => false,
        'multiple_category' => false,
        'use_brand' => false,
        'use_companies' => true,
        'use_gallery' => true,
        // features
        'features' => true,
        'variants' => true,
        'gallery' => true,
        'auto_code' => false, // generate random auto code
        'qty' => true,
        'use_image' => true,
        'use_tags' => true,
        'buying_price' => true,
        'prices' => true,
        'cargo_price' => true,
        // attributes
        'max_sub_attribute_count' => 10
    ],
    'use_album_gallery' => false,


    // multi lang
    'MULTI_LANG' => false,
    'multi_currency' => false,
    'default_language' => 1, // Ayar::LANG_TR
    'default_currency' => 1, // Ayar::CURRENCY_TL
    'default_currency_prefix' => 'tl', // must be : tl,usd,eur
    'force_lang_currency' => true, // para birimini dile göre varsayılanı seçmeye zorlar

    // index page configs
    'homepage' => [
        'show_products' => true,
        'show_orders' => true,
        'show_order_widgets' => true,
    ],

    // kuponlar kaç dakika geriye kadar  aktif-pasif kontrol edilsin
    'check_coupon_prev_minute' => 5,
    'check_campaign_prev_minute' => 5,

    'iyzico' => [
        'order_url' => env("IYZIPAY_ORDER_URL", "https://sandbox-merchant.iyzipay.com/transactions/"),
        'api_key' => env('IYZIPAY_API_KEY', "DEFAULT_KEY"),
        'api_secret' => env('IYZIPAY_API_SECRET', "DEFAULT_SECRET_KEY"),
        'base_url' => env('IYZIPAY_BASE_URL', "DEFAULT_BASE_URL"),
    ],
    // image quality %x if value is null image not be resized
    'image_quality' => [
        'banner' => 90,
        'blog' => null,
        'our_team' => null,
        'category' => null,
        'product' => null,
        'product_image' => null,
        'product_company' => null,
        'content' => null,
        'reference' => null,
        'coupon' => null,
        'campaign' => null,
        'gallery' => null,
        'gallery_item' => 60,
        'service' => 60,
        'service_thumb' => 40,
    ],
    // admin account
    'username' => 'admin@admin.com',
    'password' => '141277kk',

    'store_email' => 'store@admin.com',
    'store_password' => '141277kk',

    'customer_email' => 'customer@admin.com',
    'customer_password' => '141277kk',

];
$data['menus'] = [
    0 => [
        'title' => 'Modüller',
        'users' => [
            'icon' => 'fa fa-user',
            'permission' => 'Kullanici@listUsers',
            'title' => 'users',
            'routeName' => 'admin.users',
            'active' => $data['module_status']['user']
        ],
        'roles' => [
            'icon' => 'fa fa-user-times',
            'permission' => 'Role@list',
            'title' => 'role_management',
            'routeName' => 'admin.roles',
            'active' => $data['module_status']['user']
        ],
        // B2B STORES
        'my_services' => [
            'icon' => 'fa fa-list',
            'permission' => 'ServiceStore@index',
            'title' => 'my_services',
            'routeName' => 'admin.services.stores',
            'active' => $data['module_status']['service']
        ],
        'service' => [
            'icon' => 'fa fa-list',
            'permission' => 'Service@index',
            'title' => 'services',
            'routeName' => 'admin.services',
            'active' => $data['module_status']['service'],
            'subs' => [
                [
                    'icon' => 'fa fa-circle-o',
                    'permission' => 'Table@services',
                    'title' => 'local_services',
                    'routeName' => 'admin.services',
                    'active' => $data['module_status']['service'],
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'permission' => 'Table@services',
                    'title' => 'local_pending_services',
                    'routeName' => 'admin.services',
                    'active' => $data['module_status']['service'],
                    'key' => 'pendingServices',
                    'param' => '?status=2'
                ],
//                [
//                    'icon' => 'fa fa-circle-o',
//                    'permission' => 'CompanyService@index',
//                    'title' => 'company_services',
//                    'routeName' => 'admin.services.company.list',
//                    'active' => $data['module_status']['service'],
//                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'permission' => 'ServiceType@index',
                    'title' => 'services_types',
                    'routeName' => 'admin.services.type.list',
                    'active' => $data['module_status']['service'],
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'permission' => 'ServiceAttribute@index',
                    'title' => 'services_attributes',
                    'routeName' => 'admin.services.attribute.list',
                    'active' => $data['module_status']['service'],
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'permission' => 'ServiceComment@index',
                    'title' => 'service_comments',
                    'routeName' => 'admin.services-comments.index',
                    'active' => $data['module_status']['service'],
                ]
            ]
        ],
        'service_comments' => [
            'icon' => 'fa fa-comments',
            'permission' => 'ServiceStore@index',
            'title' => 'service_comments',
            'routeName' => 'admin.services-comments.index',
            'active' => $data['module_status']['service'],
        ],
        'locations' => [
            'icon' => 'fa fa-building',
            'permission' => 'Location@index',
            'title' => 'locations',
            'routeName' => 'admin.locations',
            'active' => $data['module_status']['locations'],
            'subs' => [
                [
                    'icon' => 'fa fa-circle-o',
                    'permission' => 'Location@index',
                    'title' => 'locations',
                    'routeName' => 'admin.locations',
                    'active' => $data['module_status']['locations']
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'permission' => 'LocationType@index',
                    'title' => 'location_types',
                    'routeName' => 'admin.locations.types',
                    'active' => $data['module_status']['locations']
                ],
            ],
        ],
        'packages' => [
            'icon' => 'fa fa-archive',
            'permission' => 'Location@index',
            'title' => 'packages',
            'routeName' => 'admin.packages.index',
            'active' => $data['module_status']['packages'],
            'subs' => [
                [
                    'icon' => 'fa fa-circle-o',
                    'permission' => 'Location@index',
                    'title' => 'packages',
                    'routeName' => 'admin.packages.index',
                    'active' => $data['module_status']['locations']
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'permission' => 'LocationType@index',
                    'title' => 'packages_transactions',
                    'routeName' => 'admin.packages.transactions.index',
                    'active' => $data['module_status']['locations']
                ],
            ],
        ],
        'appointment' => [
            'icon' => 'fa fa-table',
            'permission' => 'Appointment@index',
            'title' => 'appointment',
            'routeName' => 'admin.appointments',
            'active' => $data['module_status']['appointment']
        ],
        'banner' => [
            'icon' => 'fa fa-image',
            'permission' => 'Banner@list',
            'title' => 'banner',
            'routeName' => 'admin.banners',
            'active' => $data['module_status']['banner']
        ],
        'blog' => [
            'icon' => 'fa fa-book',
            'permission' => 'Blog@list',
            'title' => 'blog',
            'routeName' => 'admin.blog',
            'active' => $data['module_status']['blog']
        ],
        'blog_category' => [
            'icon' => 'fa fa-align-center',
            'permission' => 'BlogCategory@list',
            'title' => 'blog_category',
            'routeName' => 'admin.blog_category',
            'active' => $data['blog']['use_categories']
        ],
        'our_team' => [
            'icon' => 'fa fa-users',
            'permission' => 'OurTeam@list',
            'title' => 'our_team',
            'routeName' => 'admin.our_team',
            'active' => $data['module_status']['our_team']
        ],
        'contact' => [
            'icon' => 'fa fa-phone',
            'permission' => 'Contact@list',
            'title' => 'contact',
            'routeName' => 'admin.contact',
            'active' => $data['module_status']['contact']
        ],
        'e_bulten' => [
            'icon' => 'fa fa-envelope',
            'permission' => 'EBulten@list',
            'title' => 'e_bulten',
            'routeName' => 'admin.ebulten',
            'active' => $data['module_status']['e_bulten']
        ],
        'category' => [
            'icon' => 'fa fa-files-o',
            'permission' => 'Kategori@listCategories',
            'title' => 'categories',
            'routeName' => 'admin.categories',
            'active' => $data['product']['use_category']
        ],
        'products' => [
            'icon' => 'fa fa-list',
            'permission' => 'Urun@listProducts',
            'title' => 'products',
            'routeName' => 'admin.products',
            'active' => $data['module_status']['product'],
            'subs' => [
                ['icon' => 'fa fa-circle-o',
                    'permission' => 'Urun@listProducts',
                    'title' => 'product_list',
                    'routeName' => 'admin.products',
                    'active' => $data['module_status']['product']
                ],
                ['icon' => 'fa fa-circle-o',
                    'permission' => 'UrunOzellik@list',
                    'title' => 'product_features',
                    'routeName' => 'admin.product.attribute.list',
                    'active' => $data['product']['use_attribute']
                ],
                ['icon' => 'fa fa-circle-o',
                    'permission' => 'UrunYorum@list',
                    'title' => 'product_comments',
                    'routeName' => 'admin.product.comments.list',
                    'active' => $data['product']['use_comment']
                ],
            ]
        ],
        'orders' => [
            'icon' => 'fa fa-shopping-bag',
            'permission' => 'Siparis@list',
            'title' => 'orders',
            'routeName' => 'admin.orders',
            'active' => $data['module_status']['order'],
            'subs' => [
                ['icon' => 'fa fa-circle-o',
                    'permission' => 'Urun@listProducts',
                    'title' => 'orders',
                    'routeName' => 'admin.orders',
                    'key' => 'pendingOrderCount',
                    'active' => $data['module_status']['order']
                ],
                ['icon' => 'fa fa-undo',
                    'permission' => 'Urun@listProducts',
                    'title' => 'refund_requests',
                    'routeName' => 'admin.orders',
                    'param' => '?pendingRefund=1',
                    'key' => 'pendingRefundRequests',
                    'active' => $data['module_status']['order']
                ],
            ]
        ],
        'references' => [
            'icon' => 'fa fa-list-alt',
            'permission' => 'Referans@list',
            'title' => 'references',
            'routeName' => 'admin.reference',
            'active' => $data['module_status']['reference']
        ],
        'content_management' => [
            'icon' => 'fa fa-align-center',
            'permission' => 'IcerikYonetim@list',
            'title' => 'content_management',
            'routeName' => 'admin.content',
            'active' => $data['module_status']['content_management']
        ],
        'gallery' => [
            'icon' => 'fa fa-camera',
            'permission' => 'FotoGallery@list',
            'title' => 'gallery_management',
            'routeName' => 'admin.gallery',
            'active' => $data['module_status']['gallery']
        ],
        'error_orders' => [
            'icon' => 'fa fa-exclamation',
            'permission' => 'Siparis@iyzicoErrorOrderList',
            'title' => 'failed_orders',
            'routeName' => 'admin.orders.iyzico_logs',
            'active' => $data['module_status']['order']
        ],
        'coupons' => [
            'icon' => 'fa fa-tags',
            'permission' => 'Kupon@list',
            'title' => 'coupons',
            'routeName' => 'admin.coupons',
            'active' => $data['module_status']['coupon']
        ],
        'campaign' => [
            'icon' => 'fa fa-percent',
            'permission' => 'Kampanya@list',
            'title' => 'campaigns',
            'routeName' => 'admin.campaigns',
            'active' => $data['module_status']['campaign']
        ],
        'logs' => [
            'icon' => 'fa fa-exclamation',
            'permission' => 'Log@list',
            'title' => 'error_management',
            'routeName' => 'admin.logs',
            'active' => $data['module_status']['log']
        ],
    ], 1 => [
        'title' => 'Genel',
        'settings' => [
            'icon' => 'fa fa-key',
            'permission' => 'Ayarlar@list',
            'title' => 'configs',
            'routeName' => 'admin.config.list',
            'active' => $data['module_status']['setting'],
            'subs' => [
                ['icon' => 'fa fa-key',
                    'permission' => 'Ayarlar@list',
                    'title' => 'general',
                    'routeName' => 'admin.config.list',
                    'active' => $data['module_status']['setting']
                ],
                ['icon' => 'fa fa-truck',
                    'permission' => 'Cargo@index',
                    'title' => 'cargo',
                    'routeName' => 'admin.cargo.index',
                    'active' => $data['module_status']['cargo']
                ],
            ]
        ],
        'product_brands' => [
            'icon' => 'fa fa-medium',
            'permission' => 'UrunMarka@list',
            'title' => 'product_brands',
            'routeName' => 'admin.product.brands.list',
            'active' => $data['product']['use_brand']
        ],
        'product_companies' => [
            'icon' => 'fa fa-building',
            'permission' => 'UrunFirma@list',
            'title' => 'product_companies',
            'routeName' => 'admin.product.company.list',
            'active' => $data['product']['use_companies']
        ],
        'sss' => [
            'icon' => 'fa fa-info',
            'permission' => 'SSS@list',
            'title' => 'faq',
            'routeName' => 'admin.sss',
            'active' => $data['module_status']['sss']
        ],
        'report' => [
            'icon' => 'fa fa-info-circle',
            'permission' => 'Report@index',
            'title' => 'report',
            'routeName' => 'admin.report',
            'active' => $data['module_status']['report']
        ],
    ],

];
return $data;
