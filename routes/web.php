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

Route::get('/', 'HomeController@welcome');
Auth::routes();
Route::get('/logout', 'Auth\AuthController@logout');
Route::get('/language/{locale}', 'Auth\AuthController@changeLanguage');

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['auth', 'locale']], function () {

    Route::get('/mailbox',              'MailboxController@index');
    Route::get('/mailbox/create',       'MailboxController@getCreate');
    Route::get('/mailbox/delete/{id}',  'MailboxController@getDelete');
    Route::get('/mailbox/update/{id}',  'MailboxController@getUpdate');
    Route::post('/mailbox/update/{id}', 'MailboxController@postUpdate');
    Route::post('/mailbox/create',      'MailboxController@postCreate');

    Route::get('/alias',                'AliasController@index');
    Route::get('/alias/create',         'AliasController@getCreate');
    Route::get('/alias/delete/{id}',    'AliasController@getDelete');
    Route::get('/alias/update/{id}',    'AliasController@getUpdate');
    Route::post('/alias/update/{id}',   'AliasController@postUpdate');
    Route::post('/alias/create',        'AliasController@postCreate');

    Route::get('/domain',               'DomainController@index');
    Route::get('/domain/create',        'DomainController@getCreate');
    Route::get('/domain/delete/{id}',   'DomainController@getDelete');
    Route::get('/domain/update/{id}',   'DomainController@getUpdate');
    Route::post('/domain/update/{id}',  'DomainController@postUpdate');
    Route::post('/domain/create',       'DomainController@postCreate');
    
});

Route::group(['middleware' => ['auth', 'locale', 'super_admin']], function () {

    Route::get('/user',               'UserController@index');
    Route::get('/user/create',        'UserController@getCreate');
    Route::get('/user/delete/{id}',   'UserController@getDelete');
    Route::get('/user/update/{id}',   'UserController@getUpdate');
    Route::post('/user/update/{id}',  'UserController@postUpdate');
    Route::post('/user/create',       'UserController@postCreate');
    Route::get('/user/toggle/{id}/{domain}', 'UserController@toggleDomain');

});