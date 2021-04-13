<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'news'], function () {
    Route::get('/',        [NewsController::class, 'index'])->name('listing_of_news');
    Route::get('/create',   [NewsController::class, 'manage'])->name('create_news');
    Route::post('/create', [NewsController::class, 'create']);

    Route::get('/{id}',        [NewsController::class, 'view'])->name('view_news')->where('id', '[0-9]+');
    Route::get('/{id}/edit',   [NewsController::class, 'manage'])->name('edit_news')->where('id', '[0-9]+');
    Route::post('/{id}/edit',  [NewsController::class, 'update'])->where('id', '[0-9]+');
});