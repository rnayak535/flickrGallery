<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin;

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
    // return view('welcome');
    return redirect(url('login'));
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin', [admin::class, 'index']);
Route::get('/admin/gallery_category', [admin::class, 'galleryCategory']);
Route::post('/admin/add_new_category', [admin::class, 'addNewCategory']);
Route::get('/admin/delete_category', [admin::class, 'deleteCategory']);
Route::post('/admin/edit_category', [admin::class, 'editCategory']);
