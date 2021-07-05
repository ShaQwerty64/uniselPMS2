<?php

use App\Http\Controllers\AddAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\ViewProjectController;
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
    Route::get ('/roles_manager',[AddAdminController::class,'index'])->middleware('permission:modify admin|modify viewer|modify projects')->name('addadmin');

    Route::get ('/roles_manager/m/rerole'        ,[AddAdminController::class,'reRole'       ])->middleware('permission:modify projects')->name('addadmin.rerole');
    Route::post('/roles_manager/a/{admin}/remove',[AddAdminController::class,'destroyAdmin' ])->middleware('permission:modify admin')->name('addadmin.removeAdmin');
    Route::post('/roles_manager/v/{admin}/remove',[AddAdminController::class,'destroyViewer'])->middleware('permission:modify viewer')->name('addadmin.removeViewer');

    Route::middleware(['permission:modify projects'])->group(function (){
        Route::get ('/adder'                 , [AdminController::class, 'index'     ])->name('admin');
        Route::post('/adder/{big}/delete'    , [AdminController::class, 'destroy'   ])->name('admin.del');
        Route::post('/adder/{big}/delete_all', [AdminController::class, 'destroyAll'])->name('admin.delAll');
        Route::post('/adder/{sub}/delete_sub', [AdminController::class, 'destroySub'])->name('admin.delSub');
    });


    //Project managers only
    Route::middleware(['permission:edit projects'])->group(function (){
        Route::get('/editor', [EditController::class,'index'])->name('edit');
        Route::post('/editor', [EditController::class,'goto']);
        Route::get('/editor/sub/{sub}', [EditController::class,'indexSub'])->name('edit.sub');
        Route::post('/editor/sub/{sub}',[EditController::class,'modifySubTasks']);
        Route::get('/editor/big/{big:name}', [EditController::class,'indexBig'])->name('edit.big');
        Route::post('/editor/big/{big:name}', [EditController::class,'modifyBig']);
    });



    //Top-management only
    Route::get('/viewer', [ViewProjectController::class,'index'])->middleware('permission:view projects')->name('view');
});


