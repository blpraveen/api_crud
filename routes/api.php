<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\EventsController;
use App\Http\Controllers\API\CommentsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'login']);

Route::get('news',[NewsController::class, 'index'])->name('news.index');
Route::middleware('auth:api')->group(function(){
 
Route::post('news/create',[NewsController::class, 'store'])->name('news.store')->middleware('permission:news-create');
 
Route::get('news/edit/{id}',[NewsController::class, 'show'])->name('news.edit')->middleware('permission:news-edit');
 
Route::patch('news/{id}',[NewsController::class, 'update'])->name('news.update')->middleware('permission:news-edit');
 
Route::delete('news/{id}',[NewsController::class, 'destroy'])->name('news.destroy')->middleware('permission:news-delete');

Route::post('event/get',[EventsController::class, 'get'])->name('event.get')->middleware('permission:events-read');
Route::post('event/create',[EventsController::class, 'store'])->name('event.store')->middleware('permission:events-create');
 
Route::get('event/edit/{id}',[EventsController::class, 'show'])->name('event.edit')->middleware('permission:events-edit');
 
Route::patch('event/{id}',[EventsController::class, 'update'])->name('event.update')->middleware('permission:events-edit');
 
Route::delete('event/{id}',[EventsController::class, 'destroy'])->name('event.destroy')->middleware('permission:events-delete');
Route::post('comment/create',[CommentsController::class, 'store'])->name('comment.store')->middleware('permission:comments-create');
Route::delete('comment/{id}',[CommentsController::class, 'destroy'])->name('comment.delete')->middleware('permission:comments-delete');  
});