<?php


use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('auth/google', 'GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'GoogleController@handleGoogleCallback');


Auth::routes(['verify' => true]);



Route::get('/', 'HomeController@index')->middleware('verified');
Route::get('/{id}', 'CategoryController@show')->middleware('verified')->name('category.index');

Route::get('/{id}/{forumid}', 'ForumController@show')->middleware('verified')->name('forum.show');

Route::get('/{id}/thread/homepage', 'ThreadController@index')->middleware('verified')->name('thread.show');
Route::get('/thread/{id}', 'ThreadController@show')->middleware('verified')->name('thread.detail');



//--------Profile------------------------//

Route::get('/profile/{id}', 'UserController@show')->middleware('verified')->name('profile.index');

Route::get('/profile/edit/{id}', 'UserController@edit')->middleware('verified')->name('profile.edit');

Route::post('/profile/edit/confirm/{id}', 'UserController@confirm')->middleware('verified')->name('profile.edit.confirm');

Route::post('/profile/update/{id}', 'UserController@update')->middleware('verified')->name('profile.update');


//--------Profile------------------------//

//--------Account------------------------//

Route::get('/account/index/{id}', 'ProfileController@show')->middleware('verified')->name('account.profile');

Route::get('/account/personal-details/{id}', 'ProfileController@create')->middleware('verified')->name('account.profile.add');

Route::post('/account/personal-details/{id}/create', 'ProfileController@store')->middleware('verified')->name('account.profile.store');

Route::get('/account/personal-details/{id}/edit', 'ProfileController@edit')->middleware('verified')->name('account.profile.edit');

Route::post('/account/personal-details/{id}/update', 'ProfileController@update')->middleware('verified')->name('account.profile.update');

//--------Account------------------------//

//--------For MANAGER-------------------------------------------------------------------------------------------------//
Route::group([
    'prefix' => 'manager/{id}/thread',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------thread------------------------//

    Route::get('/add', 'ThreadController@create')->middleware('verified')->name('manager.thread.add');

    //Confirm Add thread    
    Route::post('/add/confirm', 'ThreadController@confirmadd')->middleware('verified')->name('manager.thread.add.confirm');
    //Confirm Add thread

    Route::post('/create', 'ThreadController@store')->middleware('verified')->name('manager.thread.create');

    Route::get('/{threadid}/edit', 'ThreadController@edit')->middleware('verified')->name('manager.thread.edit');

    //Confirm Update thread
    Route::post('/{threadid}/update/confirm', 'ThreadController@confirmupdate')->middleware('verified')->name('manager.thread.update.confirm');
    //Confirm Update thread

    Route::post('/{threadid}/update', 'ThreadController@update')->middleware('verified')->name('manager.thread.update');

    Route::get('/{threadid}/delete', 'ThreadController@destroy')->middleware('verified')->name('manager.thread.delete');

    //--------thread------------------------//

    //--------Tag------------------------//
    Route::get('/add', 'ThreadController@create')->middleware('verified')->name('manager.thread.add');
    Route::post('/create', 'ThreadController@store')->middleware('verified')->name('manager.thread.create');
    //--------Tag------------------------//
});

Route::group([
    'prefix' => 'manager/Forum/{id}',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------Forum------------------------//

    Route::get('/add', 'ForumController@create')->middleware('verified')->name('manager.forum.add');

    Route::post('/create', 'ForumController@store')->middleware('verified')->name('manager.forum.create');
 
    Route::get('/edit', 'ForumController@edit')->middleware('verified')->name('manager.forum.edit');

    Route::post('/update', 'ForumController@update')->middleware('verified')->name('manager.forum.update');

    Route::get('/delete', 'ForumController@delete')->middleware('verified')->name('manager.forum.delete');

    Route::get('/restore', 'ForumController@restore')->middleware('verified')->name('manager.forum.restore');
    //--------Forum------------------------//
});

//--------For MANAGER-------------------------------------------------------------------------------------------------//


//--------For ADMIN-------------------------------------------------------------------------------------------------//
Route::group([
    'prefix' => 'admin/{id}/thread',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {
    //--------thread------------------------//
    Route::get('/add', 'ThreadController@create')->middleware('verified')->name('admin.thread.add');

    //Confirm Add thread
    Route::post('/add/confirm', 'ThreadController@confirmadd')->middleware('verified')->name('admin.thread.add.confirm');
    //Confirm Add thread

    Route::post('/create', 'ThreadController@store')->middleware('verified')->name('admin.thread.create');


    Route::get('/{threadid}/edit', 'ThreadController@edit')->middleware('verified')->name('admin.thread.edit');

    //Confirm Update thread
    Route::post('/{threadid}/update/confirm', 'ThreadController@confirmupdate')->middleware('verified')->name('admin.thread.update.confirm');
    //Confirm Update thread

    Route::post('/{threadid}/update', 'ThreadController@update')->middleware('verified')->name('admin.thread.update');


    Route::get('/{threadid}/delete', 'ThreadController@destroy')->middleware('verified')->name('admin.thread.delete');

    Route::get('/{threadid}/restore', 'ThreadController@restore')->middleware('verified')->name('admin.thread.restore');

    //--------thread------------------------//
});


Route::group([
    'prefix' => 'admin',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    Route::get('/dashboard', 'AdminPanelController@index')->middleware('verified')->name('admin.dashboard');
    //--------Export------------------------//

    Route::get('/users/export', 'UserController@all')->middleware('verified')->name('admin.export.user');
    Route::get('/export/users', 'UserController@export')->middleware('verified')->name('admin.export.users');

    Route::get('/threads/export', 'ThreadController@all')->middleware('verified')->name('admin.export.thread');
    Route::get('/export/threads', 'ThreadController@export')->middleware('verified')->name('admin.export.threads');

    //--------Export------------------------//
    
    //--------Import------------------------//
    Route::post('/import/threads', 'ThreadController@import')->middleware('verified')->name('admin.import.threads');
    //--------Import------------------------//

    //--------Managing Users------------------------//
    Route::get('/member/lists', 'AdminPanelController@users')->middleware('verified');
    Route::get('/member/{id}/edit', 'AdminPanelController@editmember')->middleware('verified');
    Route::post('/member/{id}/confirm', 'AdminPanelController@confirmMember')->middleware('verified');
    Route::post('/member/{id}/update', 'AdminPanelController@updateusers')->middleware('verified');
    Route::get('/member/{id}/delete', 'AdminPanelController@destroyusers')->middleware('verified');

    //--------Managing Users------------------------//

    //--------Managing Managers------------------------//
    Route::get('/manager/lists', 'AdminPanelController@managers')->middleware('verified');
    Route::get('/manager/{id}/edit', 'AdminPanelController@editmanager')->middleware('verified');
    Route::post('/manager/{id}/confirm', 'AdminPanelController@confirmManager')->middleware('verified');
    Route::post('/manager/{id}/update', 'AdminPanelController@updatemanagers')->middleware('verified');
    Route::get('/manager/{id}/delete', 'AdminPanelController@destroymanagers')->middleware('verified');

    //--------Managing Managers------------------------//

    //--------Managing Admins------------------------//
    Route::get('/lists', 'AdminPanelController@admins')->middleware('verified');
    Route::get('/admin/{id}/edit', 'AdminPanelController@editadmin')->middleware('verified');
    Route::post('/admin/{id}/confirm', 'AdminPanelController@confirmforAdmin')->middleware('verified');
    Route::post('/admin/{id}/update', 'AdminPanelController@updateadmins')->middleware('verified');
    Route::get('/admin/{id}/delete', 'AdminPanelController@destroyadmins')->middleware('verified');

    //--------Managing Admins------------------------//

    
});
Route::group([
    'prefix' => 'admin/tag',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Tag------------------------//

    Route::get('/add', 'TagController@create')->middleware('verified')->name('admin.tag.add');

    Route::post('/create', 'TagController@store')->middleware('verified')->name('admin.tag.create');
 
    //--------Tag------------------------//
});

Route::group([
    'prefix' => 'admin/Category',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Category------------------------//

    Route::get('/add', 'CategoryController@create')->middleware('verified')->name('admin.category.add');

    Route::post('/create', 'CategoryController@store')->middleware('verified')->name('admin.category.create');
 
    //--------Category------------------------//
});

Route::group([
    'prefix' => 'admin/Forum/{id}',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Forum------------------------//

    Route::get('/add', 'ForumController@create')->middleware('verified')->name('admin.forum.add');

    Route::post('/create', 'ForumController@store')->middleware('verified')->name('admin.forum.create');
 
    Route::get('/edit', 'ForumController@edit')->middleware('verified')->name('admin.forum.edit');

    Route::post('/update', 'ForumController@update')->middleware('verified')->name('admin.forum.update');

    Route::get('/delete', 'ForumController@destroy')->middleware('verified')->name('admin.forum.delete');

    Route::get('/restore', 'ForumController@restore')->middleware('verified')->name('admin.forum.restore');
    //--------Forum------------------------//
});
//--------For ADMIN-------------------------------------------------------------------------------------------------//


//--------For Member-------------------------------------------------------------------------------------------------//
Route::group(['middleware' => 'App\Http\Middleware\MemberMiddleware'], function () {
});
//--------For Member-------------------------------------------------------------------------------------------------//
