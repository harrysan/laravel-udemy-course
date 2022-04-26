<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('home.index', []);
// })->name('home.index');

// Route::get('/contact', function () {
//     return view('home.contact');
// })->name('home.contact');

Route::get('/', [HomeController::class,'home'])->name('home');
    //->middleware('auth');

Route::get('/contact', [HomeController::class,'contact'])->name('contact');

Route::get('secret', [HomeController::class, 'secret'])
        ->name('secret')
        ->middleware('can:home.secret'); //using laravel authorization system

// Route::get('/posts/{$id}', function($id) {
//     return view('posts.partial.post', ['posts' => BlogPost::findOrFail($id)]);
// });
Route::resource('posts', PostsController::class);
    // ->only(['index','show','create','store', 'edit', 'update']);
// only, except
Route::get('/posts/tag/{tag}', [PostTagController::class, 'index'])->name('posts.tags.index');

Route::resource('posts.comments', PostCommentController::class)->only(['store']);

Route::resource('users.comments', UserCommentController::class)->only(['store']);
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

Auth::routes();

