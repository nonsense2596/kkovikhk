<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authsch\UserController;
use App\Http\Controllers\Authsch\SocialController;
use App\Http\Controllers\IndexController;

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

Route::get('/', [IndexController::class,'index']);

Route::group(['middleware' => 'web'], function (){
    Route::get('/user',[UserController::class,'index'])->middleware('auth');
});

Route::get('/auth/schonherz', [SocialController::class, 'schonherzRedirect'])->name('login');
Route::get('/auth/schonherz/callback', [SocialController::class, 'loginWithSchonherz']);
Route::get('/auth/schonherz/logout',[SocialController::class, 'logOutOfSchonFuckingHerz']);
