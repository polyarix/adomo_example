<?php

Route::get('/', 'SiteController@index');

Route::post('ckeditor/upload', 'SiteController@upload')->name('ckeditor.upload');

Route::post('set_city', 'SiteController@setCity')->name('set_city');
Route::post('search', 'SiteController@search');

Route::get('autofit', 'SiteController@autofit')->name('autofit');

Route::get('pay', 'Cabinet\CabinetController@pay')->name('pay');
Route::post('pay_handle', 'Cabinet\CabinetController@payHandle')->name('pay.handle');

Auth::routes(['verify' => true]);
Route::get('sign-up', 'Auth\VerificationController@verifyPhone')->name('verification.phone');
Route::get('sign-up/work-data', 'Auth\RegisterController@workData')->name('sign-up.work-data');
Route::get('sign-up/categories', 'Auth\RegisterController@categories')->name('sign-up.categories');

Route::get('login/sso', 'Auth\UserEchoController@login')->name('login.sso');
Route::get('support', 'Auth\UserEchoController@redirect')->name('support');

Route::get('/login/{network}/callback', 'Auth\NetworkController@callback');
Route::get('/login/{network}/{type?}', 'Auth\NetworkController@redirect')->name('login.network');

Route::get('home', 'HomeController@index')->name('home')->middleware('profile_filled');

Route::get('doc/{document}', 'SiteController@doc')->name('doc');

Route::group(['prefix' => 'category', 'as' => 'tasks.', 'namespace' => 'Advert', 'middleware' => ['executors_only']], function() {
    Route::get('recommended', 'TasksController@recommended')->name('recommended');
    Route::get('offers', 'TasksController@offers')->name('offers');
});

// Orders
Route::group(['as' => 'advert.', 'namespace' => 'Advert'], function() {
    Route::group(['prefix' => 'orders', 'as' => 'order.', 'middleware' => 'auth'], function() {
        Route::group(['middleware' => 'customers_only'], function() {
            Route::get('create/{category?}/{user?}', 'OrdersController@create')->name('create')->where(['user' => '[0-9]*']);
            Route::get('createAs/{order}', 'OrdersController@createAs')->name('repeat');
            Route::get('create-individual/{user}', 'OrdersController@createIndividual')->name('create_individual')->where(['user' => '[0-9]*']);
            Route::get('{order}/edit', 'OrdersController@edit')->name('edit');
            Route::post('{request}/reject_executor', 'OrdersController@rejectExecutor')->name('reject_executor');
            Route::post('{request}/set_executor', 'OrdersController@setExecutor')->name('set_executor');
        });

        Route::get('{order}/review', 'OrdersController@review')->name('review');
        Route::get('{order}/finish', 'OrdersController@finish')->name('finish');
        Route::get('{order}', 'OrdersController@show')->name('show');
    });

    Route::group(['prefix' => 'task', 'as' => 'task.'], function() {
        Route::get('{order}', 'TasksController@show')->name('show');
    });
});

// Users
Route::get('user/banned', 'UsersController@banned')->name('user.banned')->middleware('auth');

Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
    Route::group(['prefix' => '{user}'], function () {
        Route::get('/', 'UsersController@details')->name('details');

        Route::group(['prefix' => 'portfolio', 'as' => 'portfolio.'], function() {
            Route::get('/', 'UsersController@albumsList')->name('index');
            Route::get('{album}', 'UsersController@albumShow')->name('show');
        });
    });
});

Route::post('api/user/login', 'Auth\LoginController@login');

// API
Route::group(['prefix' => 'api', 'as' => 'api.', 'namespace' => 'Api'], function () {
    Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function () {
        Route::post('reviews', 'DetailsController@reviews');
        // ...

        Route::group(['prefix' => 'sign_up', 'as' => 'sign-up.'], function () {
            Route::post('save', 'ProfileController@save');
            Route::post('work_data', 'ProfileController@saveWorkData');
            Route::post('avatar_upload', 'ProfileController@uploadAvatar')->name('avatar_upload');
            // ...

            Route::group(['middleware' => 'auth'], function() {
                Route::post('resend_phone', 'ProfileController@resendPhone')->name('resend_phone');
                Route::post('resend_email', 'ProfileController@resendEmail')->name('resend_email');
                // ...
            });
        });

        Route::group(['middleware' => 'auth', 'prefix' => 'cabinet', 'as' => 'cabinet.'], function() {
            Route::put('verification', 'VerificationController@update')->name('verification.update');
            Route::post('file-upload', 'VerificationController@uploadFile')->name('verification.file.upload');
            Route::delete('file-delete', 'VerificationController@deleteFile')->name('verification.file.delete');

            // ...

            Route::group(['prefix' => 'chat', 'as' => 'chat.', 'middleware' => ['auth', 'talk']], function () {
                Route::post('create', 'ChatController@create')->name('create');
                Route::get('threads', 'ChatController@index')->name('threads');
                Route::post('messages', 'ChatController@messages')->name('messages');
                // ...
            });

            Route::group(['middleware' => ['executors_only'], 'prefix' => 'services', 'as' => 'services.', 'namespace' => 'Executor'], function() {
                Route::post('/', 'ServicesController@store')->name('store');
                Route::get('/', 'ServicesController@index')->name('index');
                Route::delete('{service}', 'ServicesController@remove')->name('destroy');
                Route::put('{service}', 'ServicesController@update')->name('update');
            });
        });
    });

    Route::group(['prefix' => 'companies', 'as' => 'companies.'], function () {
        // ...
        Route::post('upload_logo', 'CompaniesController@uploadLogo')->name('upload_logo')->middleware('throttle:3');
    });
});

Route::get('{page}', 'SiteController@slug')->name('page');