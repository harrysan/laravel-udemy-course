<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
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

// Route::get('/', function () {
//     return view('home.index', []);
// })->name('home.index');

// Route::get('/contact', function () {
//     return view('home.contact');
// })->name('home.contact');

Route::get('/', [HomeController::class,'home'])
    ->name('home.index');
    //->middleware('auth');
Route::get('/contact', [HomeController::class,'contact'])
    ->name('home.contact');

// Route::get('/posts/{$id}', function($id) {
//     return view('posts.partial.post', ['posts' => BlogPost::findOrFail($id)]);
// });
Route::resource('posts', PostsController::class);
    // ->only(['index','show','create','store', 'edit', 'update']);
// only, except
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
