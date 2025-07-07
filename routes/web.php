<?php

use App\Http\Controllers\FrontendController;
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
Route::get('/chatbot', [FrontendController::class, 'chatbot'])
    ->name('frontend.chatbot');
//Route::get('/{slug}', '\App\Http\Controllers\FrontendController@cate')->name('frontend.cate');
// Route cho trang đăng ký gói cước
Route::get('/register-package', [FrontendController::class, 'registerPackage'])
    ->name('frontend.register_package');

Route::post('/save-contact', [FrontendController::class, 'saveContact'])
    ->name('frontend.save_contact');

Route::post('/ajaxLoadMoreCate', 'App\Http\Controllers\FrontendController@ajaxLoadMoreCate')->name('frontend.load_more_cate');

Route::get('set-lang/{value}', [FrontendController::class, 'setLang'])->name('frontend.set-lang');
Route::get('search', [FrontendController::class, 'search'])->name('frontend.search');
Route::get('tag/{value}', [FrontendController::class, 'tag'])->name('frontend.tag');

// Route cho bài viết (post) với đuôi .html
Route::get('/{postSlug}.html', [FrontendController::class, 'post'])
    ->name('frontend.post');

// Route cho danh mục (category)
Route::get('/{categorySlug}', [FrontendController::class, 'cate'])
    ->name('frontend.cate');
