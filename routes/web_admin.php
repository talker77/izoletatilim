<?php

/*
|--------------------------------------------------------------------------
| Web Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::redirect('', '/admin/giris/');
    Route::match(['get', 'post'], 'giris', 'KullaniciController@login')->name('admin.login');
    Route::get('/clear_cache', 'AnasayfaController@cacheClear')->name('admin.clearCache');
    Route::group(['middleware' => ['admin', 'admin.module', 'role', 'admin.order.counts', 'admin.language']], function () {
        Route::get('home', 'AnasayfaController@index')->name('admin.home_page');
        Route::get('contacts', 'AnasayfaController@contacts')->name('admin.contacts');
        Route::get('cikis', 'KullaniciController@logout')->name('admin.logout');

        //----- Admin/User/..
        Route::group(['prefix' => 'user/'], function () {
            Route::get('/', 'KullaniciController@listUsers')->name('admin.users');
            Route::get('new', 'KullaniciController@newOrEditUser')->name('admin.user.new');
            Route::get('edit/{user_id}', 'KullaniciController@newOrEditUser')->name('admin.user.edit');
            Route::post('save/{user_id}', 'KullaniciController@saveUser')->name('admin.user.save');
            Route::delete('delete/{user_id}', 'KullaniciController@deleteUser')->name('admin.user.delete');
        });

        //----- Admin/Tables/..
        Route::group(['prefix' => 'tables/'], function () {
            Route::get('appointments', 'TableController@appointments')->name('admin.tables.appointments');
            Route::get('reports', 'TableController@reports')->name('admin.tables.reports');
            Route::get('users', 'TableController@users')->name('admin.tables.users');
            Route::get('blog', 'TableController@blog')->name('admin.tables.blog');
            Route::get('services', 'TableController@services')->name('admin.tables.services');
            Route::get('service-attributes', 'TableController@serviceAttributes')->name('admin.tables.service-attributes');
            Route::get('service-types', 'TableController@serviceTypes')->name('admin.tables.service-types');
            Route::get('locations', 'TableController@locations')->name('admin.tables.locations');
            Route::get('companies', 'TableController@companies')->name('admin.tables.companies');
            Route::get('location-types', 'TableController@locationTypes')->name('admin.tables.locations.types');
            Route::get('company-services', 'TableController@companyServices');
            Route::get('services-stores', 'TableController@serviceStores');
            Route::get('service-comments', 'TableController@serviceComments');
            Route::get('package-transactions', 'TableController@packageTransactions');
        });

        //----- Admin/services/..
        Route::resource('services', 'ServiceController', [
            'names' => [
                'index' => 'admin.services',
                'store' => 'admin.services.store',
                'update' => 'admin.services.update',
                'create' => 'admin.services.create',
                'edit' => 'admin.services.edit',
            ]
        ]);
        Route::group(['prefix' => 'services'], function () {
            Route::get('appointments/{service:id}', 'ServiceController@appointments');
            Route::delete('delete-image/{image:id}', 'ServiceController@deleteImage');

            Route::get('appointments/detail/{serviceAppointment:id}', 'ServiceController@appointmentDetail')->name('admin.services.appointments.detail');
            Route::post('appointments/store/{service:id}', 'ServiceController@createStoreAppointment')->name('admin.services.appointments.create');
            Route::post('approve-service/{service:id}', 'ServiceController@approveService')->name('admin.services.approve');
            Route::post('reject-service/{service:id}', 'ServiceController@rejectService')->name('admin.services.reject');
            Route::put('appointments/{serviceAppointment:id}', 'ServiceController@updateStoreAppointment')->name('admin.services.appointments.update');
            Route::delete('appointments/{serviceAppointment:id}', 'ServiceController@deleteStoreAppointment')->name('admin.services.appointments.delete');
        });

        Route::resource('services-store', 'ServiceStoreController', [
            'names' => [
                'index' => 'admin.services.stores',
                'store' => 'admin.services.stores.store',
                'update' => 'admin.services.stores.update',
                'create' => 'admin.services.stores.create',
                'edit' => 'admin.services.stores.edit',
            ]
        ]);

        //----- Admin/services/..
        // todo : gate
        Route::resource('services-comments', 'ServiceCommentController', ['as' => 'admin']);

        //----- Admin/appointments/..
        Route::resource('appointment', 'AppointmentController', [
            'names' => [
                'index' => 'admin.appointments',
                'store' => 'admin.appointments.store',
                'update' => 'admin.appointments.update',
                'create' => 'admin.appointments.create',
                'edit' => 'admin.appointments.edit',
            ]
        ]);

        // ---- service/attributes
        Route::group(['prefix' => 'service/attributes'], function () {
            Route::get('/', 'ServiceAttributeController@index')->name('admin.services.attribute.list');
            Route::get('get-attributes-by-type/{serviceType:id}', 'ServiceAttributeController@getAttributesByType')->name('admin.services.attribute.get-by-type');
            Route::get('new', 'ServiceAttributeController@detail')->name('admin.services.attribute.new');
            Route::get('{id}/edit', 'ServiceAttributeController@detail')->name('admin.services.attribute.edit');
            Route::put('update/{attribute:id}', 'ServiceAttributeController@update')->name('admin.services.attribute.update');
            Route::post('create', 'ServiceAttributeController@store')->name('admin.services.attribute.store');
            Route::delete('{serviceAttribute:id}', 'ServiceAttributeController@destroy')->name('admin.services.attribute.delete');
        });
        // ---- service/types
        Route::group(['prefix' => 'service/types'], function () {
            Route::get('/', 'ServiceTypeController@index')->name('admin.services.type.list');
            Route::get('new', 'ServiceTypeController@detail')->name('admin.services.type.new');
            Route::get('{id}/edit', 'ServiceTypeController@detail')->name('admin.services.type.edit');
            Route::put('update/{type:id}', 'ServiceTypeController@update')->name('admin.services.type.update');
            Route::post('create', 'ServiceTypeController@store')->name('admin.services.type.store');
            Route::delete('{type:id}', 'ServiceTypeController@destroy')->name('admin.services.type.delete');
        });

        // ---- company-services
        Route::group(['prefix' => 'company-services'], function () {
            Route::get('/', 'CompanyServiceController@index')->name('admin.services.company.list');
            Route::get('new', 'CompanyServiceController@detail')->name('admin.services.company.new');
            Route::get('appointments/{serviceCompany:id}', 'CompanyServiceController@appointments')->name('admin.services.company.appointments');
            Route::get('{serviceCompany:id}/edit', 'CompanyServiceController@detail')->name('admin.services.company.edit');
            Route::put('update/{serviceCompany:id}', 'CompanyServiceController@update')->name('admin.services.company.update');
            Route::post('create', 'CompanyServiceController@store')->name('admin.services.company.store');
            Route::delete('{serviceCompany:id}', 'CompanyServiceController@destroy')->name('admin.services.company.delete');
        });

        // ---- locations
        Route::resource('locations', 'LocationController', [
            'names' => [
                'index' => 'admin.locations',
                'store' => 'admin.locations.store',
                'update' => 'admin.locations.update',
                'create' => 'admin.locations.create',
                'edit' => 'admin.locations.edit',
            ]
        ]);
        // ---- service/types
        Route::group(['prefix' => 'location/types'], function () {
            Route::get('/', 'LocationTypeController@index')->name('admin.locations.types');
            Route::get('new', 'LocationTypeController@detail')->name('admin.locations.type.new');
            Route::get('{id}/edit', 'LocationTypeController@detail')->name('admin.locations.type.edit');
            Route::put('update/{type:id}', 'LocationTypeController@update')->name('admin.locations.type.update');
            Route::post('create', 'LocationTypeController@store')->name('admin.locations.type.store');
            Route::delete('{type:id}', 'LocationTypeController@destroy')->name('admin.locations.type.delete');
        });

        // ---- Admin/packages
        Route::group(['prefix' => 'packages'], function () {
            Route::get('/', 'PackageController@index')->name('admin.packages.index');
            Route::get('new', 'PackageController@detail')->name('admin.packages.new');
            Route::get('{package:id}', 'PackageController@detail')->name('admin.packages.edit');
            Route::put('{package:id}', 'PackageController@update')->name('admin.packages.update');
            Route::post('', 'PackageController@store')->name('admin.packages.store');
            Route::delete('{package:id}', 'PackageController@destroy')->name('admin.packages.delete');
        });
        Route::group(['prefix' => 'package-transactions'], function () {
            Route::get('/', 'PackageUserController@index')->name('admin.packages.transactions.index');
            Route::get('{packageUser:id?}', 'PackageUserController@detail')->name('admin.packages.transactions.edit');
            Route::put('{packageUser:id}', 'PackageUserController@update')->name('admin.packages.transactions.update');
            Route::post('{user:id}', 'PackageUserController@store')->name('admin.packages.transactions.store');
        });

        //----- Admin/category/..
        Route::group(['prefix' => 'category/'], function () {
            Route::get('/', 'KategoriController@listCategories')->name('admin.categories');
            Route::get('new', 'KategoriController@newOrEditCategory')->name('admin.category.new');
            Route::get('edit/{user_id}', 'KategoriController@newOrEditCategory')->name('admin.category.edit');
            Route::post('save/{user_id}', 'KategoriController@saveCategory')->name('admin.category.save');
            Route::get('delete/{user_id}', 'KategoriController@deleteCategory')->name('admin.category.delete');
            // ajax
            Route::get('getSubCategoriesByCategoryId/{categoryID}', 'KategoriController@getSubCategoriesByID')->name('admin.category.get-sub-categories');
            Route::post('clone-for-language/{category:id}/{lang}', 'KategoriController@cloneForLanguage')->name('admin.category.clone-for-language');
            Route::post('sync-all-categories', 'KategoriController@syncParentCategoriesLanguages');
        });

        //----- Admin/Products/..
        Route::group(['prefix' => 'product/'], function () {
            Route::get('/', 'UrunController@listProducts')->name('admin.products');
            Route::get('new', 'UrunController@newOrEditProduct')->name('admin.product.new');
            Route::get('edit/{product_id}', 'UrunController@newOrEditProduct')->name('admin.product.edit');
            Route::post('save/{product_id}', 'UrunController@saveProduct')->name('admin.product.save');
            Route::get('delete/{product:id}', 'UrunController@deleteProduct')->name('admin.product.delete');

            // ajax
            Route::get('ajax', 'UrunController@ajax');
            Route::get('getAllProductsForSearch', 'UrunController@getAllProductsForSearchAjax');
            Route::get('deleteProductDetailById/{id}', 'UrunController@deleteProductDetailById')->name('deleteProductDetailById');
            Route::get('getProductDetailWithSubAttributes/{product_id}', 'UrunController@getProductDetailWithSubAttributes')->name('getProductDetailWithSubAttributes');
            Route::get('deleteProductVariant/{variant_id}', 'UrunController@deleteProductVariant')->name('deleteProductVariant');
            Route::get('deleteProductImage/{id}', 'UrunController@deleteProductImage')->name('deleteProductImage');
            Route::post('clone-for-language/{product:id}/{lang}', 'UrunController@cloneForLanguage')->name('admin.product.clone-for-language');

            Route::group(['prefix' => 'attributes/'], function () {
                Route::get('/', 'UrunOzellikController@list')->name('admin.product.attribute.list');
                Route::get('new', 'UrunOzellikController@detail')->name('admin.product.attribute.new');
                Route::get('edit/{id}', 'UrunOzellikController@detail')->name('admin.product.attribute.edit');
                Route::post('update/{attribute:id}', 'UrunOzellikController@save')->name('admin.product.attribute.save');
                Route::post('create', 'UrunOzellikController@create')->name('admin.product.attribute.create');
                Route::get('delete/{id}', 'UrunOzellikController@delete')->name('admin.product.attribute.delete');

                // ajax
                Route::get('get-sub-attributes-by-attribute-id/{id}', 'UrunOzellikController@getSubAttributesByAttributeId')->name('getSubAttributesByAttributeId');
                Route::get('get-all-product-attributes', 'UrunOzellikController@getAllProductAttributes')->name('getAllProductAttributes');

                Route::post('deleteSubAttribute/{id}', 'UrunOzellikController@deleteSubAttribute')->name('admin.product.attribute.subAttribute.delete');
                Route::post('get-new-product-sub-attribute-html', 'UrunOzellikController@addNewProductSubAttribute');

            });

            Route::group(['prefix' => 'comments/'], function () {
                Route::get('/', 'UrunYorumController@list')->name('admin.product.comments.list');
                Route::get('new', 'UrunYorumController@detail')->name('admin.product.comments.new');
                Route::get('edit/{id}', 'UrunYorumController@detail')->name('admin.product.comments.edit');
                Route::post('save/{id}', 'UrunYorumController@save')->name('admin.product.comments.save');
                Route::get('delete/{id}', 'UrunYorumController@delete')->name('admin.product.comments.delete');
            });
            Route::group(['prefix' => 'brands/'], function () {
                Route::get('/', 'UrunMarkaController@list')->name('admin.product.brands.list');
                Route::get('new', 'UrunMarkaController@detail')->name('admin.product.brands.new');
                Route::get('edit/{id}', 'UrunMarkaController@detail')->name('admin.product.brands.edit');
                Route::post('save/{id}', 'UrunMarkaController@save')->name('admin.product.brands.save');
                Route::get('delete/{id}', 'UrunMarkaController@delete')->name('admin.product.brands.delete');
            });
            Route::group(['prefix' => 'company/'], function () {
                Route::get('/', 'UrunFirmaController@list')->name('admin.product.company.list');
                Route::get('new', 'UrunFirmaController@detail')->name('admin.product.company.new');
                Route::get('edit/{id}', 'UrunFirmaController@detail')->name('admin.product.company.edit');
                Route::post('save/{id}', 'UrunFirmaController@save')->name('admin.product.company.save');
                Route::delete('{company:id}/delete', 'UrunFirmaController@delete')->name('admin.product.company.delete');
            });

        });

        //----- Admin/Orders/..
        Route::group(['prefix' => 'order/'], function () {
            Route::get('/', 'SiparisController@list')->name('admin.orders');
            Route::get('/iyzico-fails', 'IyzicoController@iyzicoErrorOrderList')->name('admin.orders.iyzico_logs');
            Route::get('/iyzico-fails/{id}', 'IyzicoController@iyzicoErrorOrderDetail')->name('admin.orders.iyzico_logs_detail');
            Route::get('snapshot/{order:id}', 'SiparisController@snapshot')->name('admin.orders.snapshot');
            Route::get('edit/{orderId}', 'SiparisController@newOrEditOrder')->name('admin.order.edit');
            Route::post('save/{orderId}', 'SiparisController@save')->name('admin.order.save');
            Route::get('delete/{id}', 'SiparisController@deleteOrder')->name('admin.order.delete');

            // iyzico cancel
            Route::post('cancel-all/{order:id}', 'SiparisController@cancelOrder')->name('admin.order.cancel');
            Route::post('cancel-order-item/{item:id}', 'SiparisController@cancelOrderItem')->name('admin.orders.cancel-order-item');

            // iyzico refund items
            Route::post('refund-item', 'SiparisController@refundItem')->name('admin.orders.refund-basket-item');

            Route::get('edit/{order:id}/invoice', 'SiparisController@invoiceDetail')->name('admin.order.invoice');
            Route::get('ajax', 'SiparisController@ajax')->name('admin.order.ajax');

            Route::post('basket/{basketID}', 'BasketController@show');
        });

        //----- Admin/Banners/..
        Route::group(['prefix' => 'banner/'], function () {
            Route::get('/', 'BannerController@list')->name('admin.banners');
            Route::get('new', 'BannerController@newOrEditForm')->name('admin.banners.new');
            Route::get('edit/{id}', 'BannerController@newOrEditForm')->name('admin.banners.edit');
            Route::post('save/{id}', 'BannerController@save')->name('admin.banners.save');
            Route::get('delete/{id}', 'BannerController@delete')->name('admin.banners.delete');
        });

        //----- Admin/Configs/..
        Route::group(['prefix' => 'configs/'], function () {
            Route::get('list', 'AyarlarController@list')->name('admin.config.list');
            Route::get('show/{id}', 'AyarlarController@show')->name('admin.config.show');
            Route::post('save/{id}', 'AyarlarController@save')->name('admin.config.save');

            Route::resource('cargo', 'CargoController', ['as' => 'admin']);
        });

        //----- Admin/Logs/..
        Route::group(['prefix' => 'logs/'], function () {
            Route::get('/', 'LogController@list')->name('admin.logs');
            Route::get('show/{id}', 'LogController@show')->name('admin.log.show');
            Route::get('json/{log:id}', 'LogController@json')->name('admin.log.json');
            Route::get('delete/{id}', 'LogController@delete')->name('admin.log.delete');
            Route::get('deleteAll', 'LogController@deleteAll')->name('admin.log.delete_all');
        });


        //----- Admin/Coupons/..
        Route::group(['prefix' => 'sss/'], function () {
            Route::get('/', 'SSSController@list')->name('admin.sss');
            Route::get('new', 'SSSController@newOrEditForm')->name('admin.sss.new');
            Route::get('edit/{id}', 'SSSController@newOrEditForm')->name('admin.sss.edit');
            Route::post('save/{id}', 'SSSController@save')->name('admin.sss.save');
            Route::get('delete/{id}', 'SSSController@delete')->name('admin.sss.delete');
        });


        //----- Admin/Content/..
        Route::group(['prefix' => 'content/'], function () {
            Route::get('/', 'IcerikYonetimController@list')->name('admin.content');
            Route::get('new', 'IcerikYonetimController@newOrEditForm')->name('admin.content.new');
            Route::get('edit/{id}', 'IcerikYonetimController@newOrEditForm')->name('admin.content.edit');
            Route::post('save/{id}', 'IcerikYonetimController@save')->name('admin.content.save');
            Route::get('delete/{id}', 'IcerikYonetimController@delete')->name('admin.content.delete');
        });
        //----- Admin/Roles/..
        Route::group(['prefix' => 'roles/'], function () {
            Route::get('/', 'RoleController@list')->name('admin.roles');
            Route::get('new', 'RoleController@newOrEditForm')->name('admin.role.new');
            Route::get('edit/{id}', 'RoleController@newOrEditForm')->name('admin.role.edit');
            Route::post('save/{id}', 'RoleController@save')->name('admin.role.save');
            Route::get('delete/{id}', 'RoleController@delete')->name('admin.role.delete');
        });
        //----- Admin/Blog/..
        Route::group(['prefix' => 'blog'], function () {
            Route::get('/', 'BlogController@list')->name('admin.blog');
            Route::get('new', 'BlogController@newOrEditForm')->name('admin.blog.new');
            Route::get('edit/{id}', 'BlogController@newOrEditForm')->name('admin.blog.edit');
            Route::post('save/{id}', 'BlogController@save')->name('admin.blog.save');
            Route::get('delete/{id}', 'BlogController@delete')->name('admin.blog.delete');
        });
        //----- Admin/BlogCategory/..
        Route::group(['prefix' => 'blog-category'], function () {
            Route::get('/', 'BlogCategoryController@list')->name('admin.blog_category');
            Route::get('new', 'BlogCategoryController@newOrEdit')->name('admin.blog_category.new');
            Route::get('edit/{id}', 'BlogCategoryController@newOrEdit')->name('admin.blog_category.edit');
            Route::post('save/{id}', 'BlogCategoryController@save')->name('admin.blog_category.save');
            Route::get('delete/{BlogCategory:id}', 'BlogCategoryController@delete')->name('admin.blog_category.delete');
        });
        //----- Admin/EBulten/..
        Route::group(['prefix' => 'ebulten/'], function () {
            Route::get('/', 'EBultenController@list')->name('admin.ebulten');
            Route::get('delete/{id}', 'EBultenController@delete')->name('admin.ebulten.delete');
        });
        //----- Admin/Contact/..
        Route::group(['prefix' => 'contact/'], function () {
            Route::get('/', 'ContactController@list')->name('admin.contact');
            Route::get('ajax', 'ContactController@ajax')->name('admin.contact.ajax');
            Route::get('delete/{contact:id}', 'ContactController@delete')->name('admin.contact.delete');
        });

        //----Admin/Report/....
        Route::group(['prefix' => 'report'], function () {
            Route::get('','ReportController@index')->name('admin.report');
        });
    });


});


Route::get('/home', 'AnasayfaController@index')->name('home');
