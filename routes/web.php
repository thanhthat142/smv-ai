<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', '\App\Http\Controllers\FrontendController@index')->name('frontend.index');
Route::get('/contact', '\App\Http\Controllers\FrontendController@contact')->name('frontend.contact');
Route::get('/{slug}', '\App\Http\Controllers\FrontendController@cate')->name('frontend.cate');
