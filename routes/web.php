<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\front\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    Route::match(['get', 'post'], 'login', [AdminController::class, 'login']);
    
    Route::group(['middleware' =>['admin']], function(){
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('logout', [AdminController::class, 'logout']);
        Route::match(['get','post'], '/update_password', [AdminController::class, 'update_password']);
        Route::match(['get','post'], '/update-admin-details', [AdminController::class, 'updateAdminDetails']);
        Route::match(['get','post'], '/check_current_password', [AdminController::class, 'check_current_password']);

        // Subadmins Routes
        Route::get('subadmins',[AdminController::class, 'subadmins']);
        Route::post('update-subadmin-status', [AdminController::class, 'updateSubadminStatus']);
        Route::match(['get','post'], '/add-edit-subadmin/{id?}', [AdminController::class, 'addEditSubadmin']);
        Route::get('delete-subadmin/{id?}', [AdminController::class, 'deleteSubadmin']);

        // Display Cms Pages 
        Route::get('cms-pages', [CmsController::class, 'index']);
        // dd('hello');
        Route::post('update-cms-pages-status', [CmsController::class, 'update']);
        Route::match(['get','post'], '/add-edit-cms-page/{id?}', [CmsController::class, 'edit']);
        Route::get('delete-cms-page/{id}', [CmsController::class, 'destroy']);

        // Categories
        Route::match(['get', 'post'], '/categories', [CategoryController::class, 'index'])->name('admin.categories');
        Route::match(['get', 'post'], '/addcategories', [CategoryController::class, 'addCategory'])->name('admin.categories.add');

    });
});

Route::get('dashboard', [DashboardController::class, 'dashboard_front']);
Route::match(['get', 'post'], '/user_login', [DashboardController::class, 'user_login']);
// Route::match(['get', 'post'], '/user_login', [DashboardController::class, 'create_login']);

