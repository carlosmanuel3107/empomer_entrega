<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GiftController;


Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'categories'], function () {        
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/create', [CategoryController::class, 'create']);        
        Route::get('/show/{id}', [CategoryController::class, 'show']);        
        Route::put('/update/{id}', [CategoryController::class, 'update']);
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);
    });

    Route::group(['prefix' => 'gifts'], function () {        
        Route::get('/', [GiftController::class, 'index']);
        Route::post('/create', [GiftController::class, 'create']);        
        Route::get('/show/{id}', [GiftController::class, 'show']);        
        Route::put('/update/{id}', [GiftController::class, 'update']);
        Route::delete('/delete/{id}', [GiftController::class, 'destroy']);
    });

    Route::group(['prefix' => 'customers'], function () {        
        Route::get('/', [CustomerController::class, 'index']);
        Route::post('/create', [CustomerController::class, 'create']);        
        Route::get('/show/{id}', [CustomerController::class, 'show']);        
        Route::put('/update/{id}', [CustomerController::class, 'update']);
        Route::delete('/delete/{id}', [CustomerController::class, 'destroy']);
    });

    Route::group(['prefix' => 'bills'], function () {        
        Route::get('/', [BillController::class, 'index']);
        Route::get('/customer/{id}', [BillController::class, 'customer']);
        Route::post('/create', [BillController::class, 'create']);        
        Route::get('/show/{id}', [BillController::class, 'show']);        
        Route::put('/update/{id}', [BillController::class, 'update']);
        Route::delete('/delete/{id}', [BillController::class, 'destroy']);
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [PostController::class, 'index']);
        Route::post('/create', [PostController::class, 'create']);        
        Route::get('/show/{id}', [PostController::class, 'show']);        
        Route::put('/update/{id}', [PostController::class, 'update']);
        Route::delete('/delete/{id}', [PostController::class, 'destroy']);
    });
});

Route::group(['middleware' => 'api'], function ($router) {
    Route::get('menu', 'MenuController@index');

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register'); 

    Route::resource('notes', 'NotesController');

    Route::resource('resource/{table}/resource', 'ResourceController');
    
    Route::group(['middleware' => 'admin'], function ($router) {

        Route::resource('mail',        'MailController');
        Route::get('prepareSend/{id}', 'MailController@prepareSend')->name('prepareSend');
        Route::post('mailSend/{id}',   'MailController@send')->name('mailSend');

        Route::resource('bread',  'BreadController');   //create BREAD (resource)

        Route::resource('users', 'UsersController')->except( ['create', 'store'] );

        Route::prefix('menu/menu')->group(function () { 
            Route::get('/',         'MenuEditController@index')->name('menu.menu.index');
            Route::get('/create',   'MenuEditController@create')->name('menu.menu.create');
            Route::post('/store',   'MenuEditController@store')->name('menu.menu.store');
            Route::get('/edit',     'MenuEditController@edit')->name('menu.menu.edit');
            Route::post('/update',  'MenuEditController@update')->name('menu.menu.update');
            Route::get('/delete',   'MenuEditController@delete')->name('menu.menu.delete');
        });
        Route::prefix('menu/element')->group(function () { 
            Route::get('/',             'MenuElementController@index')->name('menu.index');
            Route::get('/move-up',      'MenuElementController@moveUp')->name('menu.up');
            Route::get('/move-down',    'MenuElementController@moveDown')->name('menu.down');
            Route::get('/create',       'MenuElementController@create')->name('menu.create');
            Route::post('/store',       'MenuElementController@store')->name('menu.store');
            Route::get('/get-parents',  'MenuElementController@getParents');
            Route::get('/edit',         'MenuElementController@edit')->name('menu.edit');
            Route::post('/update',      'MenuElementController@update')->name('menu.update');
            Route::get('/show',         'MenuElementController@show')->name('menu.show');
            Route::get('/delete',       'MenuElementController@delete')->name('menu.delete');
        });
        Route::prefix('media')->group(function ($router) {
            Route::get('/',                 'MediaController@index')->name('media.folder.index');
            Route::get('/folder/store',     'MediaController@folderAdd')->name('media.folder.add');
            Route::post('/folder/update',   'MediaController@folderUpdate')->name('media.folder.update');
            Route::get('/folder',           'MediaController@folder')->name('media.folder');
            Route::post('/folder/move',     'MediaController@folderMove')->name('media.folder.move');
            Route::post('/folder/delete',   'MediaController@folderDelete')->name('media.folder.delete');;

            Route::post('/file/store',      'MediaController@fileAdd')->name('media.file.add');
            Route::get('/file',             'MediaController@file');
            Route::post('/file/delete',     'MediaController@fileDelete')->name('media.file.delete');
            Route::post('/file/update',     'MediaController@fileUpdate')->name('media.file.update');
            Route::post('/file/move',       'MediaController@fileMove')->name('media.file.move');
            Route::post('/file/cropp',      'MediaController@cropp');
            Route::get('/file/copy',        'MediaController@fileCopy')->name('media.file.copy');

            Route::get('/file/download',    'MediaController@fileDownload');
        });

        Route::resource('roles',        'RolesController');
        Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
        Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
    });
});

