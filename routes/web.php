<?php

use App\Http\Controllers\AdminPanelController;
use App\Models\Community;
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

Route::get('/', 'HomeController@index')->name('home');

Route::get('auth/google', 'GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'GoogleController@handleGoogleCallback');


Auth::routes(['verify' => true]);


//--------Viewable Page------------------------//
Route::group([
    'prefix' => 'guest',
], function () {
    Route::get('/{id}', 'CategoryController@show')->name('category.index');

    Route::get('/{categoryid}/{forumid}', 'ForumController@show')->name('forum.show');

    Route::get('/{id}/thread/homepage', 'ThreadController@index')->name('thread.show');

    Route::get('/{id}/thread/homepage/{threadid}', 'ThreadController@show')->name('thread.detail');

    Route::get('/Community/community/community', 'CommunityController@index')->name('community.homepage');

    Route::get('/community/{id}', 'CommunityController@show')->name('community.show');
});

Route::get('/{id}/mark-as-read', 'HomeController@readAt')->name('notification.read');

Route::get('/mark-all-as-read', 'HomeController@readAll')->name('notification.read.all');

Route::get('/notifications/all', 'HomeController@showAllNotifications')->name('notifications.all');



//--------Viewable Page------------------------//

//--------Profile------------------------//
Route::group([
    'prefix' => 'profile',
], function () {
    Route::get('/{name}/{id}', 'UserController@show')->middleware('verified')->name('profile.index');

    Route::get('/edit/{name}/{id}', 'UserController@edit')->middleware('verified')->name('profile.edit');

    Route::post('/edit/confirm/{id}', 'UserController@confirm')->middleware('verified')->name('profile.edit.confirm');

    Route::post('/update/{id}', 'UserController@update')->middleware('verified')->name('profile.update');
});

//--------Profile------------------------//

//--------Account------------------------//
Route::group([
    'prefix' => 'account',
], function () {
    Route::get('/index/{id}', 'ProfileController@show')->middleware('verified')->name('account.profile');

    Route::get('/personal-details/{id}', 'ProfileController@create')->middleware('verified')->name('account.profile.add');

    Route::post('/personal-details/{id}/create', 'ProfileController@store')->middleware('verified')->name('account.profile.store');

    Route::get('/personal-details/{id}/edit', 'ProfileController@edit')->middleware('verified')->name('account.profile.edit');

    Route::post('/personal-details/{id}/update', 'ProfileController@update')->middleware('verified')->name('account.profile.update');
});


//--------Account------------------------//

//---------------Follower----------------------------/
Route::get('/{userid}/follow/Thread/{threadid}', 'ThreadController@follow')->middleware('verified')->name('follow.thread');
Route::get('/{userid}/unfollow/Thread/{threadid}', 'ThreadController@unfollow')->middleware('verified')->name('unfollow.thread');

Route::get('/{userid}/follow/Community/{communityid}', 'CommunityController@follow')->middleware('verified')->name('follow.community');
Route::get('/{userid}/unfollow/Community/{communityid}', 'CommunityController@unfollow')->middleware('verified')->name('unfollow.community');
//---------------Follower----------------------------/

//--------For MANAGER-------------------------------------------------------------------------------------------------//

Route::group([
    'prefix' => 'manager/category',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {
    Route::get('/{id}/for_manager', 'CategoryController@show')->middleware('verified')->name('manager.category.index');
});

Route::group([
    'prefix' => 'manager/{categoryid}/Forum',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------Forum------------------------//
    Route::get('/{forumid}/for_manager', 'ForumController@show')->middleware('verified')->name('manager.forum.show');

    Route::get('/add/for_manager/forum/add', 'ForumController@create')->middleware('verified')->name('manager.forum.add');

    Route::post('/create/for_manager', 'ForumController@store')->middleware('verified')->name('manager.forum.create');

    Route::get('/edit/{forumid}', 'ForumController@edit')->middleware('verified')->name('manager.forum.edit');

    Route::post('/update/{forumid}', 'ForumController@update')->middleware('verified')->name('manager.forum.update');

    Route::get('/delete/{forumid}', 'ForumController@destroy')->middleware('verified')->name('manager.forum.delete');

    Route::get('/restore/{forumid}', 'ForumController@restore')->middleware('verified')->name('manager.forum.restore');
    //--------Forum------------------------//
});

Route::group([
    'prefix' => 'manager/{id}/thread',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------thread------------------------//
    Route::get('/homepage/for_manager', 'ThreadController@index')->middleware('verified')->name('manager.thread.show');

    Route::get('/homepage/{threadid}/for_manager', 'ThreadController@show')->middleware('verified')->name('manager.thread.detail');

    Route::get('/add/for_manager', 'ThreadController@create')->middleware('verified')->name('manager.thread.add');

    //Confirm Add thread    
    Route::post('/add/confirm/for_manager', 'ThreadController@confirmadd')->middleware('verified')->name('manager.thread.add.confirm');
    //Confirm Add thread

    Route::post('/create/for_manager', 'ThreadController@store')->middleware('verified')->name('manager.thread.create');

    Route::get('/{threadid}/edit/for_manager', 'ThreadController@edit')->middleware('verified')->name('manager.thread.edit');

    //Confirm Update thread
    Route::post('/{threadid}/update/confirm/for_manager', 'ThreadController@confirmupdate')->middleware('verified')->name('manager.thread.update.confirm');
    //Confirm Update thread

    Route::post('/{threadid}/update/for_manager', 'ThreadController@update')->middleware('verified')->name('manager.thread.update');

    Route::get('/{threadid}/delete/for_manager', 'ThreadController@destroy')->middleware('verified')->name('manager.thread.delete');



    //--------thread------------------------//

});

Route::group([
    'prefix' => 'manager/Community',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------Community------------------------//
    Route::get('/community', 'CommunityController@index')->middleware('verified')->name('manager.community.homepage');

    Route::get('/community/{id}', 'CommunityController@show')->middleware('verified')->name('manager.community.show');

    //--------Community------------------------//
});



Route::group([
    'prefix' => 'manager/{id}/Post',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------Post------------------------//

    Route::post('/create', 'PostController@store')->middleware('verified')->name('manager.post.create');

    Route::get('/edit/{postid}', 'PostController@edit')->middleware('verified')->name('manager.post.edit');

    Route::post('/update/{postid}', 'PostController@update')->middleware('verified')->name('manager.post.update');

    Route::get('/delete/{postid}', 'PostController@destroy')->middleware('verified')->name('manager.post.delete');

    //--------Post------------------------//
});


Route::group([
    'prefix' => 'manager/{postid}/Comment',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------Post------------------------//

    Route::post('/create', 'CommentController@store')->middleware('verified')->name('manager.comment.create');

    Route::get('/edit/{commentid}', 'CommentController@edit')->middleware('verified')->name('manager.comment.edit');

    Route::post('/update/{commentid}', 'CommentController@update')->middleware('verified')->name('manager.comment.update');

    Route::get('/delete/{commentid}', 'CommentController@destroy')->middleware('verified')->name('manager.comment.delete');

    //--------Post------------------------//
});
Route::group([
    'prefix' => 'manager/{postid}/like',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------Post------------------------//

    Route::get('/post/like', 'LikeController@like')->middleware('verified')->name('manager.like.post');

    Route::get('/post/unlike', 'LikeController@unlike')->middleware('verified')->name('manager.unlike.post');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'manager/thread/{threadid}/Comment',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------Post------------------------//

    Route::post('/create', 'CommentController@store2')->middleware('verified')->name('manager.comment.create.thread');

    Route::get('/edit/{commentid}', 'CommentController@edit2')->middleware('verified')->name('manager.comment.edit.thread');

    Route::post('/update/{commentid}', 'CommentController@update2')->middleware('verified')->name('manager.comment.update.thread');

    Route::get('/delete/{commentid}', 'CommentController@destroy')->middleware('verified')->name('manager.comment.delete.thread');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'manager/thread/{threadid}/like',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------Post------------------------//

    Route::get('/like', 'LikeController@likethread')->middleware('verified')->name('manager.like.post.thread');

    Route::get('/unlike', 'LikeController@unlikethread')->middleware('verified')->name('manager.unlike.post.thread');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'manager/thread/{threadid}/Report',
    'middleware' => 'App\Http\Middleware\ManagerMiddleware'
], function () {

    //--------Post------------------------//
    Route::get('/create', 'ReportController@create')->name('thread.report.create');

    Route::post('/store', 'ReportController@store')->name('thread.report.store');

    //--------Post------------------------//
});
//--------For MANAGER-------------------------------------------------------------------------------------------------//





//--------For ADMIN-------------------------------------------------------------------------------------------------//
Route::group([
    'prefix' => 'admin',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    Route::get('/{id}/dashboard', 'AdminPanelController@index')->middleware('verified')->name('admin.dashboard');
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
    Route::get('/member/lists', 'AdminPanelController@users')->middleware('verified')->name('user.list');
    Route::post('/member/lists', 'AdminPanelController@searchFullText')->middleware('verified')->name('search');
    Route::get('/member/{id}/edit', 'AdminPanelController@editmember')->middleware('verified');
    Route::post('/member/{id}/confirm', 'AdminPanelController@confirmMember')->middleware('verified');
    Route::post('/member/{id}/update', 'AdminPanelController@updateusers')->middleware('verified');
    Route::get('/member/{id}/delete', 'AdminPanelController@destroyusers')->middleware('verified');

    //--------Managing Users------------------------//

    //--------Managing Managers------------------------//
    Route::get('/manager/lists', 'AdminPanelController@managers')->middleware('verified')->name('manager.list');
    Route::get('/manager/{id}/edit', 'AdminPanelController@editmanager')->middleware('verified');
    Route::post('/manager/{id}/confirm', 'AdminPanelController@confirmManager')->middleware('verified');
    Route::post('/manager/{id}/update', 'AdminPanelController@updatemanagers')->middleware('verified');
    Route::get('/manager/{id}/delete', 'AdminPanelController@destroymanagers')->middleware('verified');

    //--------Managing Managers------------------------//

    //--------Managing Admins------------------------//
    Route::get('/{id}/lists', 'AdminPanelController@admins')->middleware('verified')->name('admin.list');
    Route::get('/admin/{id}/edit', 'AdminPanelController@editadmin')->middleware('verified');
    Route::post('/admin/{id}/confirm', 'AdminPanelController@confirmforAdmin')->middleware('verified');
    Route::post('/admin/{id}/update', 'AdminPanelController@updateadmins')->middleware('verified');
    Route::get('/admin/{id}/delete', 'AdminPanelController@destroyadmins')->middleware('verified');

    //--------Managing Admins------------------------//

    //--------Managing Category By Admins------------------------//
    Route::get('/admin/categories/lists', 'AdminPanelController@Categories')->middleware('verified')->name('categories.admin.list');

    Route::get('/admin/categories/edit/{categoryid}', 'AdminPanelController@CategoriesEdit')->middleware('verified')->name('categories.admin.edit');

    Route::post('/admin/categories/update/{categoryid}', 'AdminPanelController@CategoriesUpdate')->middleware('verified')->name('categories.admin.update');

    Route::get('/admin/categories/delete/{categoryid}', 'AdminPanelController@CategoriesDelete')->middleware('verified')->name('categories.admin.delete');

    Route::get('/admin/categories/restore/{categoryid}', 'AdminPanelController@CategoriesRestore')->middleware('verified')->name('categories.admin.restore');
    //--------Managing Category By Admins------------------------//

    //--------Managing Forum By Admins------------------------//
    Route::get('/admin/forums/lists', 'AdminPanelController@Forums')->middleware('verified')->name('forums.admin.list');

    Route::get('/admin/forums/edit/{forumid}', 'AdminPanelController@ForumsEdit')->middleware('verified')->name('forums.admin.edit');

    Route::post('/admin/forums/update/{forumid}', 'AdminPanelController@ForumsUpdate')->middleware('verified')->name('forums.admin.update');

    Route::get('/admin/forums/delete/{forumid}', 'AdminPanelController@ForumsDelete')->middleware('verified')->name('forums.admin.delete');

    Route::get('/admin/forums/restore/{forumid}', 'AdminPanelController@ForumsRestore')->middleware('verified')->name('forums.admin.restore');

    //--------Managing Forum By Admins------------------------//

    //--------Managing Thread By Admins------------------------//
    Route::get('/admin/thread/lists', 'AdminPanelController@AdminsThreads')->middleware('verified')->name('admins.threads.list');

    Route::get('/admin/thread/lists/edit/{threadid}', 'AdminPanelController@AdminsThreadsEdit')->middleware('verified')->name('admins.threads.edit');

    Route::post('/admin/thread/lists/update/{threadid}', 'AdminPanelController@AdminsThreadsUpdate')->middleware('verified')->name('admins.threads.update');

    Route::get('/admin/thread/lists/delete/{threadid}', 'AdminPanelController@AdminsThreadsDelete')->middleware('verified')->name('admins.threads.delete');

    Route::get('/admin/thread/lists/restore/{threadid}', 'AdminPanelController@AdminsThreadsRestore')->middleware('verified')->name('admins.threads.restore');
    //--------Managing Thread By Admins------------------------//

    //--------Managing Thread By Admins------------------------//
    Route::get('/admin/manager/thread/lists', 'AdminPanelController@ManagersThreads')->middleware('verified')->name('managers.threads.list');

    Route::get('/admin/manager/thread/lists/edit/{threadid}', 'AdminPanelController@ManagersThreadsEdit')->middleware('verified')->name('admins.managers.threads.edit');

    Route::post('/admin/manager/thread/lists/update/{threadid}', 'AdminPanelController@ManagersThreadsUpdate')->middleware('verified')->name('admins.managers.threads.update');

    Route::get('/admin/manager/thread/lists/delete/{threadid}', 'AdminPanelController@ManagersThreadsDelete')->middleware('verified')->name('admins.managers.threads.delete');

    Route::get('/admin/manager/thread/lists/restore/{threadid}', 'AdminPanelController@ManagersThreadsRestore')->middleware('verified')->name('admins.managers.threads.restore');

    //--------Managing Thread By Admins------------------------//

    //--------Managing Community By Admins------------------------//
    Route::get('/admin/communities/lists', 'AdminPanelController@Communities')->middleware('verified')->name('communities.admin.list');

    Route::get('/admin/communities/lists/edit/{communityid}', 'AdminPanelController@CommunitiesEdit')->middleware('verified')->name('communities.admin.edit');

    Route::post('/admin/communities/lists/update/{communityid}', 'AdminPanelController@CommunitiesUpdate')->middleware('verified')->name('communities.admin.update');

    Route::get('/admin/communities/lists/delete/{communityid}', 'AdminPanelController@CommunitiesDelete')->middleware('verified')->name('communities.admin.delete');

    Route::get('/admin/communities/lists/restore/{communityid}', 'AdminPanelController@CommunitiesRestore')->middleware('verified')->name('communities.admin.restore');

    //--------Managing Community By Admins------------------------//

    //--------Managing Post By Admins------------------------//
    Route::get('/admin/posts/lists', 'AdminPanelController@Posts')->middleware('verified')->name('posts.admin.list');

    Route::get('/admin/posts/lists/edit/{postid}', 'AdminPanelController@PostsEdit')->middleware('verified')->name('posts.admin.edit');

    Route::post('/admin/posts/lists/update/{postid}', 'AdminPanelController@PostsUpdate')->middleware('verified')->name('posts.admin.update');

    Route::get('/admin/posts/lists/delete/{postid}', 'AdminPanelController@PostsDelete')->middleware('verified')->name('posts.admin.delete');

    Route::get('/admin/posts/lists/restore/{postid}', 'AdminPanelController@PostsRestore')->middleware('verified')->name('posts.admin.restore');

    //--------Managing Post By Admins------------------------//

    //--------Managing Comment By Admins------------------------//
    Route::get('/admin/comments/lists', 'AdminPanelController@Comments')->middleware('verified')->name('comments.admin.list');

    Route::get('/admin/comments/lists/edit/{commentid}', 'AdminPanelController@CommentsEdit')->middleware('verified')->name('comments.admin.edit');

    Route::post('/admin/comments/lists/update/{commentid}', 'AdminPanelController@CommentsUpdate')->middleware('verified')->name('comments.admin.update');

    Route::get('/admin/comments/lists/delete/{commentid}', 'AdminPanelController@CommentsDelete')->middleware('verified')->name('comments.admin.delete');

    Route::get('/admin/comments/lists/restore/{commentid}', 'AdminPanelController@CommentsRestore')->middleware('verified')->name('comments.admin.restore');
    //--------Managing comment By Admins------------------------//

    //--------Managing Reports By Admins------------------------//
    

    //--------Managing Reports By Admins------------------------//


});
Route::group([
    'prefix' => 'admin/Category',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Category------------------------//
    Route::get('/{id}/for_admin', 'CategoryController@show')->middleware('verified')->name('admin.category.index');

    Route::get('/{name}/add/for_admin', 'CategoryController@create')->middleware('verified')->name('admin.category.add');

    Route::post('/{name}/add/confirm/for_admin', 'CategoryController@confirmcreate')->middleware('verified')->name('admin.category.create.confirm');

    Route::post('/create/for_admin', 'CategoryController@store')->middleware('verified')->name('admin.category.create');

    Route::get('/edit/{id}/for_admin', 'CategoryController@edit')->middleware('verified')->name('admin.category.edit');

    Route::post('/edit/{id}/confirm/for_admin', 'CategoryController@confirmedit')->middleware('verified')->name('admin.category.edit.confirm');

    Route::post('/update/{id}/for_admin', 'CategoryController@update')->middleware('verified')->name('admin.category.update');

    Route::get('/delete/{id}/for_admin', 'CategoryController@destroy')->middleware('verified')->name('admin.category.delete');

    Route::get('/restore/{id}/for_admin', 'CategoryController@restore')->middleware('verified')->name('admin.category.restore');

    //--------Category------------------------//
});

Route::group([
    'prefix' => 'admin/{categoryid}/Forum',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Forum------------------------//
    Route::get('/{forumid}/for_admin', 'ForumController@show')->middleware('verified')->name('admin.forum.show');

    Route::get('/add/for_admin/Add_Forum', 'ForumController@create')->middleware('verified')->name('admin.forum.add');

    Route::post('/create/for_admin', 'ForumController@store')->middleware('verified')->name('admin.forum.create');

    Route::get('/edit/{forumid}/for_admin', 'ForumController@edit')->middleware('verified')->name('admin.forum.edit');

    Route::post('/update/{forumid}/for_admin', 'ForumController@update')->middleware('verified')->name('admin.forum.update');

    Route::get('/delete/{forumid}/for_admin', 'ForumController@destroy')->middleware('verified')->name('admin.forum.delete');

    Route::get('/restore/{forumid}/for_admin', 'ForumController@restore')->middleware('verified')->name('admin.forum.restore');
    //--------Forum------------------------//
});


Route::group([
    'prefix' => 'admin/{id}/thread',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    Route::get('/homepage', 'ThreadController@index')->middleware('verified')->name('admin.thread.show');

    Route::get('/homepage/{threadid}', 'ThreadController@show')->middleware('verified')->name('admin.thread.detail');

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
    'prefix' => 'admin/tag',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Tag------------------------//
    Route::get('/admin/tags/lists', 'AdminPanelController@Tags')->middleware('verified')->name('tags.admin.list');

    Route::get('/add', 'TagController@create')->middleware('verified')->name('admin.tag.add');

    Route::post('/create', 'TagController@store')->middleware('verified')->name('admin.tag.create');

    Route::get('/edit/{id}', 'TagController@edit')->middleware('verified')->name('admin.tag.edit');

    Route::post('/update/{id}', 'TagController@update')->middleware('verified')->name('admin.tag.update');

    Route::get('/delete/{id}', 'TagController@destroy')->middleware('verified')->name('admin.tag.delete');

    Route::get('/restore/{id}', 'TagController@restore')->middleware('verified')->name('admin.tag.restore');

    //--------Tag------------------------//
});

Route::group([
    'prefix' => 'admin/Community',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Community------------------------//
    Route::get('/community', 'CommunityController@index')->middleware('verified')->name('admin.community.homepage');

    Route::get('/community/{id}', 'CommunityController@show')->middleware('verified')->name('admin.community.show');

    Route::get('/add', 'CommunityController@create')->middleware('verified')->name('admin.community.add');

    Route::post('/create', 'CommunityController@store')->middleware('verified')->name('admin.community.create');

    Route::get('/{id}/edit', 'CommunityController@edit')->middleware('verified')->name('admin.community.edit');

    Route::post('/{id}/update', 'CommunityController@update')->middleware('verified')->name('admin.community.update');

    Route::get('/{id}/delete', 'CommunityController@destroy')->middleware('verified')->name('admin.community.delete');

    Route::get('/{id}/restore', 'CommunityController@restore')->middleware('verified')->name('admin.community.restore');

    //--------Community------------------------//
});

Route::group([
    'prefix' => 'admin/{id}/Post',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Post------------------------//

    Route::post('/create', 'PostController@store')->middleware('verified')->name('admin.post.create');

    Route::get('/edit/{postid}', 'PostController@edit')->middleware('verified')->name('admin.post.edit');

    Route::post('/update/{postid}', 'PostController@update')->middleware('verified')->name('admin.post.update');

    Route::get('/delete/{postid}', 'PostController@destroy')->middleware('verified')->name('admin.post.delete');

    Route::get('/restore/{postid}', 'PostController@restore')->middleware('verified')->name('admin.post.restore');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'admin/Post/{postid}/Comment',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Post------------------------//
    Route::post('/create', 'CommentController@store')->middleware('verified')->name('admin.comment.create');

    Route::get('/edit/{commentid}', 'CommentController@edit')->middleware('verified')->name('admin.comment.edit');

    Route::post('/update/{commentid}', 'CommentController@update')->middleware('verified')->name('admin.comment.update');

    Route::get('/delete/{commentid}', 'CommentController@destroy')->middleware('verified')->name('admin.comment.delete');

    Route::get('/restore/{commentid}', 'CommentController@restore')->middleware('verified')->name('admin.comment.restore');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'admin/{postid}/like',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Post------------------------//

    Route::get('/post/like', 'LikeController@like')->middleware('verified')->name('admin.like.post');

    Route::get('/post/unlike', 'LikeController@unlike')->middleware('verified')->name('admin.unlike.post');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'admin/thread/{threadid}/Comment',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Post------------------------//

    Route::post('/create', 'CommentController@store2')->middleware('verified')->name('admin.comment.create.thread');

    Route::get('/edit/{commentid}', 'CommentController@edit2')->middleware('verified')->name('admin.comment.edit.thread');

    Route::post('/update/{commentid}', 'CommentController@update2')->middleware('verified')->name('admin.comment.update.thread');

    Route::get('/delete/{commentid}', 'CommentController@destroy')->middleware('verified')->name('admin.comment.delete.thread');

    Route::get('/restore/{commentid}', 'CommentController@restore')->middleware('verified')->name('admin.comment.restore.thread');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'admin/{threadid}/like',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Post------------------------//

    Route::get('/thread/like', 'LikeController@likethread')->middleware('verified')->name('admin.like.post.thread');

    Route::get('/thread/unlike', 'LikeController@unlikethread')->middleware('verified')->name('admin.unlike.post.thread');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'admin/Report',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Report------------------------//
    Route::get('/lists', 'AdminPanelController@Reports')->middleware('verified')->name('reports.admin.list');

    Route::get('/delete/{id}', 'ReportController@destroy')->middleware('verified')->name('admin.report.delete');

    Route::get('/restore/{id}', 'ReportController@restore')->middleware('verified')->name('admin.report.restore');

    //--------Report------------------------//
});

Route::group([
    'prefix' => 'admin/Notifications',
    'middleware' => 'App\Http\Middleware\AdminMiddleware'
], function () {

    //--------Report------------------------//
    Route::get('/lists/for_admin', 'AdminPanelController@Notifications')->middleware('verified')->name('notifications.admin.list');

    Route::get('/delete/{id}', 'HomeController@destroy')->middleware('verified')->name('admin.notification.delete');

    //--------Report------------------------//
});
//--------For ADMIN-------------------------------------------------------------------------------------------------//


//--------For Member-------------------------------------------------------------------------------------------------//
Route::group([
    'prefix' => 'member',
    'middleware' => 'App\Http\Middleware\MemberMiddleware'
], function () {

    Route::get('/{id}', 'CategoryController@show')->name('member.category.index');

    Route::get('/{categoryid}/{forumid}', 'ForumController@show')->name('member.forum.show');


    Route::get('/Community/community/community', 'CommunityController@index')->name('member.community.homepage');

    Route::get('/community/{id}/community', 'CommunityController@show')->name('member.community.show');
});

Route::group([
    'prefix' => 'member/{id}/thread',
    'middleware' => 'App\Http\Middleware\MemberMiddleware'
], function () {

    //--------thread------------------------//
    Route::get('/homepage/for_member', 'ThreadController@index')->middleware('verified')->name('member.thread.show');

    Route::get('/homepage/{threadid}/for_member', 'ThreadController@show')->middleware('verified')->name('member.thread.detail');

    Route::get('/add/for_member', 'ThreadController@create')->middleware('verified')->name('member.thread.add');

    //Confirm Add thread    
    Route::post('/add/confirm/for_member', 'ThreadController@confirmadd')->middleware('verified')->name('member.thread.add.confirm');
    //Confirm Add thread

    Route::post('/create/for_member', 'ThreadController@store')->middleware('verified')->name('member.thread.create');

    //--------thread------------------------//

});
Route::group([
    'prefix' => 'member/thread/{threadid}/Comment',
    'middleware' => 'App\Http\Middleware\MemberMiddleware'
], function () {

    //--------Post------------------------//

    Route::post('/create', 'CommentController@store2')->middleware('verified')->name('member.comment.create.thread');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'member/thread/{threadid}/like',
    'middleware' => 'App\Http\Middleware\MemberMiddleware'
], function () {

    //--------Post------------------------//

    Route::get('/like', 'LikeController@likethread')->middleware('verified')->name('member.like.post.thread');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'member/thread/{threadid}/Report',
    'middleware' => 'App\Http\Middleware\MemberMiddleware'
], function () {

    //--------Post------------------------//
    Route::get('/create', 'ReportController@create')->name('thread.report.create');

    Route::post('/store', 'ReportController@store')->name('thread.report.store');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'member/{id}/Post',
    'middleware' => 'App\Http\Middleware\MemberMiddleware'
], function () {

    //--------Post------------------------//

    Route::post('/create', 'PostController@store')->middleware('verified')->name('member.post.create');

    //--------Post------------------------//
});

Route::group([
    'prefix' => 'member/{postid}/Comment',
    'middleware' => 'App\Http\Middleware\MemberMiddleware'
], function () {

    //--------Post------------------------//

    Route::post('/create', 'CommentController@store')->middleware('verified')->name('member.comment.create');

    //--------Post------------------------//
});
Route::group([
    'prefix' => 'member/{postid}/like',
    'middleware' => 'App\Http\Middleware\MemberMiddleware'
], function () {

    //--------Post------------------------//

    Route::get('/post/like', 'LikeController@like')->middleware('verified')->name('member.like.post');

    //--------Post------------------------//
});


//--------For Member-------------------------------------------------------------------------------------------------//
