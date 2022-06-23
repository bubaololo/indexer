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

Route::post('/indexer', [App\Http\Controllers\IndexController::class, 'sendApiRequest']);

Route::group(['middleware' => ['auth', 'verified']], function () {
  

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/services', function (){
        return view('services.services-index');
    })->name('services-index');
    Route::get('/services/indexer', function (){
        return view('services.indexer');
    })->name('indexer');

});


