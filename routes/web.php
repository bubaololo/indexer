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

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes(['verify' => true]);


Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/services', function () {
        return view('services.services-index');
    })->name('services-index');

    Route::controller(App\Services\ApiKeysService::class)
    ->group(function () {
        Route::get('/keys/keylimits', 'getKeyLimits');

        Route::get('/keys', 'getKeyList')->name('keys');
    
        Route::get('/keys/{name}', 'getSpecificKey')->name('key-page');
    
        Route::get('/keys/{name}/delete', 'deleteKey')->name('key-delete');
    
        Route::post('/keys', 'addKey')->name('key-add');
    });


    Route::controller(App\Http\Controllers\IndexerController::class)
        ->group(function () {
            Route::post('/indexer', 'sendApiRequest');

            Route::post('/progress', 'getProgressStatus');
        
            Route::get('/services/indexer', 'index')->name('indexer');
        });
});
    // Route::get('/users/{id}', [App\Http\Controllers\UsersController::class, 'userInfo'])->name('user-info')->middleware('isadmin');

    // Route::get('/mail', [App\Http\Controllers\MailController::class, 'sendMail']);
