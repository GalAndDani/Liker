<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('/home', 'HomeController@dashboard')->name('dashboard');
Route::get('/ref/{ref_id}', 'HomeController@welcomeRef');
Route::get('/verify/{token}', 'Auth\RegisterController@verify');

// Email Verification
Route::get('/verified', 'HomeController@verified')->name('verified.email');
Route::get('/unverified', 'HomeController@unverified')->name('unverified');

Route::prefix('me')->group(function () {
    Route::get('/profile', 'Manage\PagesController@profile')->name('page.profile');
    Route::post('/profile/edit', 'Manage\PagesController@profile_edit')->name('page.profile.edit');
    Route::get('/pages', 'Manage\PagesController@show')->name('page.show');
    Route::get('/pages/toggleStatus', 'Manage\PagesController@toggleStatus')->name('page.toggleStatus');
    Route::get('/pages/remove', 'Manage\PagesController@moveToTrash')->name('page.moveToTrash');
    Route::get('/add', 'Manage\PagesController@addNewPost')->name('page.add');
    Route::post('/add/store', 'Manage\PagesController@store')->name('page.store');
    Route::get('/referral', 'Manage\PagesController@referral')->name('page.referral');
});

Route::prefix('get-points')->group(function () {
    Route::prefix('facebook')->group(function () {
        // Get My Data
        Route::get('/my-images', 'FacebookApi@get_fb_my_images');
        Route::get('/my-posts', 'FacebookApi@get_fb_my_posts');

        // FB Photos Likes
        Route::get('/photo-likes', 'Manage\FacebookController@fb_photo_likes')->name('facebook.photo.likes');
        Route::get('/pages/photo-likes', 'Manage\FacebookController@get_pages_photo_like')->name('facebook.pages.photo.likes');
        Route::post('/check/photo-like', 'Manage\FacebookController@check_pages_photo_like')->name('facebook.check.photo.like');

        //FB Photo Shares
        Route::get('/photo-shares', 'Manage\FacebookController@fb_photo_shares')->name('facebook.photo.shares');
        Route::get('/pages/photo-shares', 'Manage\FacebookController@get_pages_photo_share')->name('facebook.pages.photo.shares');
        Route::post('/check/photo-share', 'Manage\FacebookController@check_pages_photo_share')->name('facebook.check.photo.share');

        //FB post Likes
        Route::get('/post-likes', 'Manage\FacebookController@fb_post_likes')->name('facebook.post.likes');
        Route::get('/pages/post-likes', 'Manage\FacebookController@get_pages_post_like')->name('facebook.pages.post.likes');
        Route::post('/check/post-like', 'Manage\FacebookController@check_pages_post_like')->name('facebook.check.post.likes');

        //FB post Shares
        Route::get('/post-shares', 'Manage\FacebookController@fb_post_shares')->name('facebook.post.shares');
        Route::get('/pages/post-shares', 'Manage\FacebookController@get_pages_post_share')->name('facebook.pages.post.shares');
        Route::post('/check/post-share', 'Manage\FacebookController@check_pages_post_share')->name('facebook.check.post.shares');
    });
});

Route::get('/test', 'Controller@index');

