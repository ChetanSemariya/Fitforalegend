<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\front\DashboardController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\AddressController;

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
        Route::match(['get','post'], '/add-edit-subadmin/{id?}', [AdminController::class, 'addEditSubadmin']);
        Route::match(['get', 'post'], '/update-role/{id?}', [AdminController::class, 'updateRole']);

        // Display Cms Pages 
        Route::get('cms-pages', [CmsController::class, 'index']);
        // dd('hello');
        Route::post('update-cms-pages-status', [CmsController::class, 'update']);
        Route::match(['get','post'], '/add-edit-cms-page/{id?}', [CmsController::class, 'edit']);
        Route::get('delete-cms-page/{id}', [CmsController::class, 'destroy']);
        
        // Categories
        Route::get('categories', [CategoryController::class, 'categories']);
        Route::post('update-category-status', [CategoryController::class, 'updateCategoryStatus']);
        Route::get('delete-category/{id}', [CategoryController::class, 'deleteCategory']);
        Route::get('delete-category-image/{id}', [CategoryController::class, 'deleteCategoryImage']);
        Route::match(['get','post'], '/add-edit-category/{id?}', [CategoryController::class, 'addEditCategory']);

        // Products
        Route::get('products', [ProductsController::class, 'products']);
        Route::post('update-product-status', [ProductsController::class, 'updateProductStatus']);
        Route::get('delete-product/{id}', [ProductsController::class, 'deleteProduct']);
        Route::match(['get','post'], 'add-edit-product/{id?}', [ProductsController::class, 'addEditProduct']);

        // states
        Route::get('states', [StateController::class, 'index']);
        Route::match(['get','post'], 'states/add', [StateController::class, 'addStates']);
        Route::match(['get','post'], 'states/edit/{id}', [StateController::class, 'editStates']);
        Route::get('/delete-state/{id}', [StateController::class, 'deleteState']);

        // city
        Route::get('cities', [CityController::class, 'index']);
        Route::match(['get','post'], 'cities/add', [CityController::class, 'addCity']);
        Route::match(['get','post'], 'cities/edit/{id}', [CityController::class, 'editCity']);
        Route::get('/delete-cities/{id}', [CityController::class, 'deleteCity']);

        // Address
        Route::get('address', [AddressController::class, 'index']);
        Route::match(['get','post'], 'address/add', [AddressController::class, 'addAddress']);
        Route::match(['get','post'], 'address/edit/{id}', [AddressController::class, 'editAddress']);
        Route::get('/delete-address/{id}', [AddressController::class, 'deleteAddress']);
    
    });
});

Route::get('dashboard', [DashboardController::class, 'dashboard_front']);
Route::match(['get', 'post'], '/user_login', [DashboardController::class, 'user_login']);
// Route::match(['get', 'post'], '/user_login', [DashboardController::class, 'create_login']);

