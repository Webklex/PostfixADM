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

Route::group(['middleware' => ['installer', 'locale']], function () {

    Auth::routes();
    Route::get('/2fa/validate',  'Auth\LoginController@getValidateToken');
    Route::post('/2fa/validate', ['middleware' => 'throttle:5', 'uses' => 'Auth\LoginController@postValidateToken']);
    Route::get('/', 'HomeController@welcome');
    Route::get('/language/{locale}', 'Auth\AuthController@changeLanguage');

    Route::get('installer', 'InstallController@setup');
    Route::get('installer/general', 'InstallController@getGeneralSetup');
    Route::post('installer/general', 'InstallController@postGeneralSetup');
    Route::get('installer/database', 'InstallController@getDatabaseSetup');
    Route::post('installer/database', 'InstallController@postDatabaseSetup');
    Route::get('installer/service', 'InstallController@getServices');
    Route::post('installer/service', 'InstallController@postServices');
    Route::get('installer/finish', 'InstallController@getFinish');

});

Route::group(['middleware' => ['auth', 'locale']], function () {

    Route::get('/redirect/back', 'HomeController@redirectBack');
    Route::get('/home',          'HomeController@welcome');
    Route::get('/logout',        'Auth\AuthController@logout');
    Route::get('/account',       'UserController@getAccount');
    Route::post('/account',      'UserController@updateAccount');

    Route::get('/settings/2fa/enable',    'Google2FAController@enableTwoFactor');
    Route::get('/settings/2fa/disable',   'Google2FAController@disableTwoFactor');

    Route::get('/mailbox',              'MailboxController@index');
    Route::get('/mailbox/create',       'MailboxController@getCreate');
    Route::get('/mailbox/test/{id}',    'MailboxController@test');
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

Route::group(['middleware' => ['auth', 'super_admin', 'locale']], function () {

    Route::get('/log',               'LogController@index');

    Route::get('/user',               'UserController@index');
    Route::get('/user/create',        'UserController@getCreate');
    Route::get('/user/delete/{id}',   'UserController@getDelete');
    Route::get('/user/update/{id}',   'UserController@getUpdate');
    Route::post('/user/update/{id}',  'UserController@postUpdate');
    Route::post('/user/create',       'UserController@postCreate');
    Route::get('/user/toggle/{id}/{domain}', 'UserController@toggleDomain');

    Route::get('/update', 'UpdateController@index');
    Route::get('/update/start/{next}', 'UpdateController@start');

    Route::get('/settings',  'SettingsController@getUpdate');
    Route::post('/settings', 'SettingsController@postUpdate');

    Route::group(['prefix' => 'api/update', 'namespace' => 'Api'], function () {

        Route::post('step/{step}/{version}', 'UpdateController@performStep');
    });
});