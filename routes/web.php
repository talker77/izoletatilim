<?php

// test

Route::get('test', 'TestController@index');
// İnitial routes
Route::get('ara', 'ServiceController@index')->name('services');
Route::get('villa-filter', 'ServiceController@filter')->name('services.filter');
Route::get('kurumsal', 'AnasayfaController@about')->name('about');
Route::get('bolgeler/{region:title?}', 'LocationController@index')->name('locations');
//Route::get('bolgeler/{region:slug}', 'LocationController@region')->name('locations.region');
Route::get('iletisim', 'IletisimController@index')->name('iletisim');
Route::get('sss', 'SSSController@list')->name('sss');
Route::get('ara/{serviceType:slug}', 'ServiceTypeController@index')->name('services.types.index');

Route::group(['prefix' => 'service'], function () {
    Route::get('forward', 'ReportController@forward')->name('services.forward');
    Route::get('tabs/{serviceID}', 'ServiceController@serviceItemDetail')->name('services.detail.tab');
    Route::get('{slug}', 'ServiceController@detail')->name('services.detail');
    //Verify Reservation
    Route::get('reservation/verify/{reservation:id}', 'ReservationController@verify')
        ->name('reservation.verify')
        ->middleware('signed');

    Route::post('gallery/{slug}', 'ServiceController@gallery')->name('services.gallery');
    Route::post('check-appointment/{serviceId}', 'ServiceController@checkAppointment')->name('services.check');
    Route::post('make-reservation/{serviceId}', 'ReservationController@makeReservation')->name('services.make-reservation')->middleware('auth:panel');
    Route::post('add-comment/{serviceId}', 'ServiceController@createComment')->name('services.add-comment')->middleware('auth:panel');
    Route::post('reservations/{service:id}/get-reserved-days', 'ReservationController@getReservedDays')->name('user.reservations.get-reserved-days');

});


Route::get('haberler', 'BlogController@list')->name('blog.list');
Route::get('haberler/{blog:slug}', 'BlogController@detail')->name('blog.detail');
Route::post('iletisim', 'IletisimController@sendMail')->name('iletisim.sendMail')->middleware(['throttle:133,10']);
Route::post('createBulten', 'EBultenController@createEBulten')->name('ebulten.create')->middleware(['throttle:3,10']);

Route::get('/', 'AnasayfaController@index')->name('homeView');
Route::get('/sitemap.xml', 'AnasayfaController@sitemap');
Route::get('/search', 'AramaController@search');


//---------- User Routes ----------------------
Route::group(['prefix' => 'kullanici'], function () {
    Route::get('/giris', 'KullaniciController@loginForm')->name('user.login');
    Route::post('/giris', 'KullaniciController@login');
    Route::delete('/cikis', 'KullaniciController@logout')->name('user.logout');
    Route::get('/kayit', 'KullaniciController@registerForm')->name('user.register');
    Route::post('/kayit', 'KullaniciController@register')->middleware('throttle:10');
    Route::get('/aktiflestir/{activation_code}', 'KullaniciController@activateUser');

    Route::group(['middleware' => ['panel','panel.package.check'], 'namespace' => 'Panel'], function () {
        Route::get('profil', 'AccountController@userDetail')->name('user.detail');
        Route::put('profile', 'AccountController@userDetailSave')->name('user.detail.update')->middleware('throttle:5');
        Route::get('dashboard', 'AccountController@dashboard')->name('user.dashboard');
        Route::get('hesabim', 'AccountController@dashboardCustomer')->name('user.customer.dashboard');
        Route::get('mesajlar', 'ChatController@index')->name('user.chat.index');
        Route::post('mesajlar', 'ChatController@create')->name('user.chat.create')->middleware('throttle:5');
//        Route::get('hizmetlerim', 'ServiceController@index')->name('user.services');
//        Route::get('hizmetlerim/{service:id}', 'ServiceController@detail')->name('user.services.detail');

        //----- PANEL/SERVICES/....
        Route::resource('services', 'ServiceController', ['as' => 'user']);
        Route::get('services/get-attributes-by-type/{serviceType:id}', 'ServiceController@getAttributesByType');
        Route::post('services/import', 'ServiceController@import')->name('user.services.import-excel')->middleware('throttle:5');
        Route::delete('services/delete-image/{image:id}', 'ServiceController@deleteImage');

        Route::group(['prefix' => 'services-appointments'], function () {
            Route::delete('delete-image/{image:id}', 'ServiceController@deleteImage');

            Route::post('detail/{serviceAppointment:id}', 'ServiceAppointmentController@show')->name('user.services.appointments.detail');
            Route::post('store/{service:id}', 'ServiceAppointmentController@store')->name('user.services.appointments.store');
            Route::put('{serviceAppointment:id}', 'ServiceAppointmentController@update')->name('user.services.appointments.update');
        });

        /** panel/packages **/
        Route::group(['prefix' => 'packages'], function () {
            Route::get('', 'PackageController@index')->name('user.packages.index');
            Route::get('{package:id}', 'PackageController@package')->name('user.packages.show');
            Route::post('{package:id}', 'PackageController@payment')->name('user.packages.create');
        });

        Route::get('reservations', 'ReservationController@index')->name('user.reservations.index');
        Route::get('reservations/{reservation:id}', 'ReservationController@show')->name('user.reservations.show');
        Route::post('reservations/{reservation:id}/approve', 'ReservationController@approve')->name('user.reservations.approve');
        Route::post('reservations/{reservation:id}/reject', 'ReservationController@reject')->name('user.reservations.reject');
        Route::delete('reservations/{reservation:id}/cancel', 'ReservationController@cancel')->name('user.reservations.cancel');

        Route::get('comments', 'CommentController@index')->name('user.comments.index');

        //----- Admin/Tables/..
        Route::group(['prefix' => 'tables/'], function () {
            Route::get('appointments/{service:id}', 'TableController@appointments')->name('panel.tables.appointments');
            Route::get('reservations', 'TableController@reservations')->name('panel.tables.reservations');
            Route::get('comments', 'TableController@comments')->name('panel.tables.comments');
            Route::get('package-transactions', 'TableController@packageTransactions')->name('panel.tables.package-transactions');
        });

        Route::get('favorilerim', 'FavoriController@list')->name('user.favorites');
        Route::delete('favoriler/{favorite:id}', 'FavoriController@delete')->name('user.favorites.delete');

        Route::get('notifications/{id}', 'AccountController@notification');
    });
});

//------------ Odeme Controller -------------------
Route::group(['prefix' => 'odeme/', 'middleware' => ['panel', 'throttle:20']], function () {
//    Route::get('adres', 'AddressController@addresses')->name('odeme.adres');
    Route::get('review', 'OdemeController@index')->name('odemeView');
    Route::post('review', 'OdemeController@payment')->name('payment.create');
    Route::get('taksit-getir', 'OdemeController@getIyzicoInstallmentCount')->name('odgetIyzicoInstallmentCount');

    Route::get('threeDSecurityRequest', 'OdemeController@threeDSecurityRequest')->name('odeme.threeDSecurityRequest');
    Route::post('threeDSecurityResponse', 'OdemeController@threeDSecurityResponse')->name('odeme.threeDSecurityResponse');
});

Route::group(['prefix' => 'locations'], function () {
    Route::get('/getTownsByCityId/{cityId}', 'CityTownController@getTownsByCityId')->name('cityTownService.getTownsByCityId');
});

//Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email')->middleware('throttle:5');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset')->middleware('throttle:5');


// Favorites Route
Route::post('favoriler/{service:id}', 'Panel\FavoriController@addToFavorites')->middleware('auth:panel');


Route::get('lang/{locale}', 'AnasayfaController@setLanguage')->name('home.setLocale');
Route::get('s/{page}', 'AnasayfaController@page')->name('page.static');

Route::group(['prefix' => 'locations'], function () {
    Route::get('/getTownsByCityId/{cityId}', 'CityTownController@getTownsByCityId')->name('cityTownService.getTownsByCityId');
    Route::get('/get-states-by-country/{countryId}', 'CityTownController@getStatesByCountry')->name('cityTownService.getStatesByCountry');
});

Route::get('{content:slug}', 'IcerikYonetimController@detail')->name('content.detail');


