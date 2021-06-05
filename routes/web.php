<?php

use App\Http\Controllers\AddAdminController;
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

Route::view('/', 'welcome');

Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    Route::view('/dashboard', 'home')->name('dashboard');

    //Admin only
    Route::get ('/add_admin'                 , [AddAdminController::class, 'index'        ])->middleware('permission:modify admin|modify viewer')->name('addadmin');
    Route::post('/add_admin/a/{admin}/remove', [AddAdminController::class, 'destroyAdmin' ])->middleware('permission:modify admin')  ->name('addadmin.removeAdmin');
    Route::post('/add_admin/v/{admin}/remove', [AddAdminController::class, 'destroyViewer'])->middleware('permission:modify viewer')->name('addadmin.removeViewer');

    Route::view('/admin', 'projects.admin')->middleware('permission:modify projects')->name('admin');

    //Project managers only
    Route::view('/projects','projects.edit')->middleware('permission:edit projects')->name('edit');

    //Top-management only
    Route::view('/view', 'projects.view')->middleware('permission:view projects')->name('view');
});


