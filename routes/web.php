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

use App\Mail\EmailPinMail;

Route::redirect('/home', '/');
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::group(['middleware' => 'roles:user'], function() {
    Route::get('/profile', 'UserController@profile')->name('user.profile');
});

Route::get('/download', 'UserController@downloads')->name('user.download');
Route::post('/login', 'UserController@login')->name('login');
Route::get('/login', 'UserController@index')->name('user.login');
Route::post('/logout', 'UserController@logout')->name('logout');
Route::get('/check-my-downloads', 'UserController@check_my_downloads')->name('user.check_my_downloads');


Route::post('/download-music', 'MusicController@download')->name('music.download');
Route::get('/checkout', 'MusicController@checkout')->name('music.checkout');
Route::post('/process-checkout', 'MusicController@process_checkout')->name('music.checkout.process');
Route::get('/music', 'MusicController@index')->name('music.index');
Route::post('/music/cart', 'MusicController@cart')->name('music.cart');
Route::delete('/music/cart', 'MusicController@remove_cart')->name('music.cart.remove');
