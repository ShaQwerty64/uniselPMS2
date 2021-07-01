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
        Route::get ('/admin'                 , [AdminController::class, 'index'     ])->name('admin');
        Route::post('/admin/{big}/delete'    , [AdminController::class, 'destroy'   ])->name('admin.del');
        Route::post('/admin/{big}/delete_all', [AdminController::class, 'destroyAll'])->name('admin.delAll');
        Route::post('/admin/{sub}/delete_sub', [AdminController::class, 'destroySub'])->name('admin.delSub');
    });


    //Project managers only
    Route::middleware(['permission:edit projects'])->group(function (){
        Route::get('/projects', [EditController::class,'index'])->name('edit');
        Route::post('/projects', [EditController::class,'goto']);
        Route::get('/projects/sub/{sub}', [EditController::class,'indexSub'])->name('edit.sub');
        Route::post('/projects/sub/{sub}', [EditController::class,'modifySub']);
        Route::post('/projects/sub/{sub}/add_milestone'    ,[EditController::class,'modifySubAddMile'])->name('edit.sub.add_mile');
        Route::post('/projects/sub/add_task/{mile}'        ,[EditController::class,'modifySubAddTask'])->name('edit.sub.add_task');
        Route::post('/projects/sub/delete_milestone/{mile}',[EditController::class,'modifySubDelMile'])->name('edit.sub.del_mile');
        Route::post('/projects/sub/delete_tasks/{task}'    ,[EditController::class,'modifySubDelTask'])->name('edit.sub.del_task');
        Route::post('/projects/sub/{sub}/modify_tasks'     ,[EditController::class,'modifySubTasks'])->name('edit.sub.tasks');
        Route::get('/projects/big/{big:name}', [EditController::class,'indexBig'])->name('edit.big');
        Route::post('/projects/big/{big:name}', [EditController::class,'modifyBig']);
    });



    //Top-management only
    Route::get('/view', [ViewProjectController::class,'index'])->middleware('permission:view projects')->name('view');
});


