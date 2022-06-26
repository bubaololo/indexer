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


Route::get('/mail', [App\Http\Controllers\MailController::class, 'sendMail']);






Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/services', function () {
        return view('services.services-index');
    })->name('services-index');

    Route::get('/services/indexer{tab?}', [App\Http\Controllers\IndexerController::class, 'index'])->name('indexer');

    Route::get('/keys/keylimits', [App\Services\ApiKeysService::class, 'getKeyLimits']);

    Route::get('/keys', [App\Services\ApiKeysService::class, 'getKeyList'])->name('keys');

    Route::get('/keys/{name}', [App\Services\ApiKeysService::class, 'getSpecificKey'])->name('key-page');
    Route::get('/keys/{name}/delete', [App\Services\ApiKeysService::class, 'deleteKey'])->name('key-delete');
    Route::post('/keys', [App\Services\ApiKeysService::class, 'addKey'])->name('key-add');

    Route::post('/indexer', [App\Http\Controllers\IndexerController::class, 'sendApiRequest']);

    // Route::get('/users/{id}', [App\Http\Controllers\UsersController::class, 'userInfo'])->name('user-info')->middleware('isadmin');


});
