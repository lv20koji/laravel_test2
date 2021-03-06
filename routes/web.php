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

// URLのfolderidが正しいかの確認
Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
    Route::post('/folders/create', 'FolderController@create');

    Route::get('/folders/{folder}/edit', 'FolderController@showEditForm')->name('folders.edit');
    Route::post('/folders/{folder}/edit', 'FolderController@edit');

    // ユーザーの権限チェック
    Route::group(['middleware' => 'can:view,folder'], function() {
        Route::get('/folders/{folder}/delete', 'FolderController@delete')->name('folders.delete');

        Route::get('/folders/{folder}/tasks', 'TaskController@index')->name('tasks.index');

        Route::get('/folders/{folder}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
        Route::post('/folders/{folder}/tasks/create', 'TaskController@create');

        Route::get('/folders/{folder}/tasks/{task_id}/edit', 'TaskController@showEditForm')->name('tasks.edit');
        Route::post('/folders/{folder}/tasks/{task_id}/edit', 'TaskController@edit');

        Route::get('/folders/{folder}/tasks/{task_id}/delete', 'TaskController@delete')->name('tasks.delete');

    });
});

Auth::routes();
