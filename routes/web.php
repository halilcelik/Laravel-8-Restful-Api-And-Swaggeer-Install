<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;






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
/*
//Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::resource('products', ProductController::class)->except(['index', 'show']);

Route::middleware('auth')->get('/home', function () {
    return view('home');
});

*/
Route::middleware('auth')->get('/secured', function() {
    return "You are authenticated!";
});
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/upload', [HomeController::class, 'upload_form'])->name('upload_form');
Route::get('/download/{filename}', [HomeController::class, 'download'])->name('download');

