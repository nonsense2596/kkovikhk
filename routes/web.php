<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authsch\UserController;
use App\Http\Controllers\Authsch\SocialController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AdminController;

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

Route::group(['middleware' => ['web','auth']], function (){
    Route::get('/user',[UserController::class,'index']);//->middleware('auth');

    Route::post('/deleteacc',[IndexController::class,'deleteaccpost']);
    Route::get('/deleteacc',[IndexController::class,'deleteaccget']);

    Route::put('/reqmailchange',[IndexController::class, 'reqmailchange']);

    Route::group(['middleware' => 'isvotingperiod'],function(){
        Route::get('/voteselect', [IndexController::class,'voteselect']);

        Route::get('/vote', [VoteController::class, 'vote']);
        Route::post('/vote', [VoteController::class, 'votepost']);
        Route::get('/youngvote', [VoteController::class, 'youngvote']);
        Route::post('/youngvote', [VoteController::class, 'youngvotepost']);
    });

    Route::group(['middleware' => 'isadmin'],function(){
        Route::get('/admin', [AdminController::class, 'admin']);

        Route::post('/deleteteacher', [AdminController::class, 'deleteteacher']);
        Route::post('/addteacher',[AdminController::class, 'addteacher']);
        Route::post('/modifyteacher',[AdminController::class, 'modifyteacher']);

        Route::post('/addteacheryoung',[AdminController::class, 'addteacheryoung']);
        Route::post('/deleteteacheryoung', [AdminController::class, 'deleteteacheryoung']);
        Route::post('/modifyteacheryoung',[AdminController::class, 'modifyteacheryoung']);

        Route::post('/setvotingperiod',[AdminController::class, 'setvotingperiod']);
        Route::post('/endvotingperiod',[AdminController::class, 'endvotingperiod']);

        Route::post('/deletevotes',[AdminController::class, 'deletevotes']);
        Route::post('/deletevotesyoung',[AdminController::class, 'deletevotesyoung']);

        //
        Route::post('/sendmail',[AdminController::class,'sendmail']);
    });

});

Route::get('/auth/schonherz', [SocialController::class, 'schonherzRedirect'])->name('login');
Route::get('/auth/schonherz/callback', [SocialController::class, 'loginWithSchonherz']);
Route::get('/auth/schonherz/logout',[SocialController::class, 'logOutOfSchonherz']);

Route::get('/unsubscribe/{mail}/{uuid}',[IndexController::class, 'unsubscribe']);


Route::get('/test', function(){
    //dd(urlencode("ká@asd>"));
    return view('emails.calltovote')
        ->with([
            'mailbody' => 'asd<a href="https://google.com">asd</a>',
            'displayName' => 'Gipsz Jakab',
            'mailaddress' => 'szatmary.peter@gmail.com',
            'unsuburl' => 'asd',
        ]);
});
