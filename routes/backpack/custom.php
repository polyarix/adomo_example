<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::group(['middleware' => 'can:administrate'], function() {
    Route::get('dashboard', 'DashboardController@index')->name('backpack.dashboard');
        CRUD::resource('categories', 'Adverts\CategoriesController');
        Route::get('categories/{category}/set_visible', 'Adverts\CategoriesController@visible')->name('advert.category.set_visible');
        Route::get('categories/{category}/set_hidden', 'Adverts\CategoriesController@hide')->name('advert.category.set_hidden');
        Route::post('categories/create_dimension', 'Adverts\CategoriesController@createDimension')->name('advert.category.create_dimension');


        CRUD::resource('category/tags', 'Adverts\TagsController');
        CRUD::resource('cities', 'CitiesController');
        CRUD::resource('variables', 'Main\\CommonVariablesController');
        CRUD::resource('faq', 'Main\\FaqController');
        Route::get('main_page', 'Main\\MainPageController@editMainPage');
        Route::post('main_page', 'Main\\MainPageController@updateMainPage');

        Route::get('about_page', 'Main\\AboutPageController@editPage');
        Route::post('about_page', 'Main\\AboutPageController@updatePage');

        Route::get('faq_page', 'Main\\FaqPageController@editPage');
        Route::post('faq_page', 'Main\\FaqPageController@updatePage');

        Route::group(['namespace' => 'Companies'], function() {
            CRUD::resource('company/articles', 'CompanyArticlesController');
            CRUD::resource('company/works', 'CompanyWorksController');
            CRUD::resource('companies', 'CompaniesController');
        });

        Route::group(['prefix' => 'blog', 'namespace' => 'Blog'], function() {
            Route::get('comments/user', 'CommentsController@searchUser')->name('comment.user.search');
            Route::get('comments/article', 'CommentsController@searchArticle')->name('comment.article.search');

            CRUD::resource('categories', 'CategoriesController');
            CRUD::resource('articles', 'ArticlesController');
            CRUD::resource('comments', 'CommentsController');

            Route::get('comments/{comment}/moderate', 'CommentsController@moderate')->name('comment.moderate');

            Route::get('articles/{article}/set_visible', 'ArticlesController@visible')->name('article.set_visible');
            Route::get('articles/{article}/set_hidden', 'ArticlesController@hide')->name('article.set_hidden');

            Route::get('{category}/set_visible', 'CategoriesController@visible')->name('category.set_visible');
            Route::get('{category}/set_hidden', 'CategoriesController@hide')->name('category.set_hidden');
        });

        // ____
        // LIBS
        CRUD::resource('menu-item', 'MenuItemCrudController');

        CRUD::resource('sliders', 'Main\\SlidersController');
        Route::get('sliders/{slider}/set_visible', 'Main\\SlidersController@visible')->name('crud.slider.set_visible');
        Route::get('sliders/{slider}/set_hidden', 'Main\\SlidersController@hide')->name('crud.slider.set_hidden');

        CRUD::resource('banners', 'Main\\BannersController');
        Route::get('banners/{banner}/set_visible', 'Main\\BannersController@visible')->name('crud.banner.set_visible');
        Route::get('banners/{banner}/set_hidden', 'Main\\BannersController@hide')->name('crud.banner.set_hidden');

        // Pages
        Route::get('page/create/{template}', 'PageCrudController@create');
        Route::get('page/{id}/edit/{template}', 'PageCrudController@edit');

        // This triggered an error before publishing the PageTemplates trait, when calling Route::controller();
        // CRUD::resource('page', $controller . '');

        // So for PageCrudController all routes are explicitly defined:
        Route::get('page/reorder', 'PageCrudController@reorder');
        Route::get('page/reorder/{lang}', 'PageCrudController@reorder');
        Route::post('page/reorder', 'PageCrudController@saveReorder');
        Route::post('page/reorder/{lang}', 'PageCrudController@saveReorder');
        Route::get('page/{id}/details', 'PageCrudController@showDetailsRow');
        Route::get('page/{id}/translate/{lang}', 'PageCrudController@translateItem');

        Route::post('page/search', [
            'as' => 'crud.page.search',
            'uses' => 'PageCrudController@search',
        ]);

        Route::resource('page', 'PageCrudController');
    });

    Route::group(['middleware' => 'can:moderate'], function() {
        Route::get('contacts_page', 'Main\\ContactsPageController@editPage');
        Route::post('contacts_page', 'Main\\ContactsPageController@updatePage');

        Route::group(['prefix' => 'contact_requests'], function() {
            Route::get('{contact}/respond', 'ContactsController@response')->name('crud.contact_requests.respond');
            Route::post('{contact}/respond', 'ContactsController@respond');
            Route::get('{contact}/view', 'ContactsController@view')->name('crud.contact_requests.view');
        });
        CRUD::resource('contact_requests', 'ContactsController');

        Route::group(['prefix' => 'advert', 'namespace' => 'Adverts'], function() {
            Route::post('orders/{order}/moderate', 'OrdersController@moderate')->name('crud.orders.moderate');
            Route::post('orders/{order}/close', 'OrdersController@close')->name('crud.orders.close');
            Route::post('orders/{order}/open', 'OrdersController@open')->name('crud.orders.open');
            Route::get('orders/{order}/reject', 'OrdersController@rejectForm')->name('crud.orders.reject');
            Route::post('orders/{order}/reject', 'OrdersController@reject');
            CRUD::resource('orders', 'OrdersController');

            Route::post('services/{service}/moderate', 'ServicesController@moderate')->name('crud.services.moderate');
            Route::post('services/{service}/close', 'ServicesController@close')->name('crud.services.close');
            Route::post('services/{service}/open', 'ServicesController@open')->name('crud.services.open');
            Route::get('services/{service}/reject', 'ServicesController@rejectForm')->name('crud.services.reject');
            Route::post('services/{service}/reject', 'ServicesController@reject');
            CRUD::resource('services', 'ServicesController');
        });

        Route::group(['namespace' => 'Users'], function() {
            Route::get('users/{user}/ban', 'UsersController@banForm')->name('crud.users.ban');
            Route::post('users/{user}/ban', 'UsersController@ban');
            Route::post('users/{user}/unban', 'UsersController@unban');
            Route::post('users/{user}/activate', 'UsersController@activate')->name('crud.users.open');
            Route::get('users/{user}/strip_premium', 'UsersController@stripPremium')->name('crud.users.strip_premium');
            Route::get('users/{user}/premium', 'UsersController@premiumForm')->name('crud.users.premium');
            Route::post('users/{user}/premium', 'UsersController@premium');
            CRUD::resource('users', 'UsersController');
        });
    });
}); // this should be the absolute last line of this file
