<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\front\DashboardController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BannersController;

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
        
        // product images 
        Route::get('delete-product-image/{id}', [ProductsController::class, 'deleteProductImage']);
        
        // product video
        Route::get('delete-product-video/{id}', [ProductsController::class, 'deleteProductVideo']);

        // Product Attributes
        Route::post('update-attribute-status', [ProductsController::class, 'updateAttributeStatus']);
        Route::get('delete-attribute/{id}', [ProductsController::class, 'deleteAttribute']);

        // brand
        Route::get('brands', [BrandController::class, 'brands']);
        Route::post('update-brand-status', [BrandController::class, 'updateBrandStatus']);
        Route::get('delete-brand/{id}', [BrandController::class, 'deleteBrand']);
        Route::match(['get','post'], 'add-edit-brand/{id?}', [BrandController::class, 'addEditBrand']);
        Route::get('delete-brand-image/{id}', [BrandController::class, 'deleteBrandImage']);
        Route::get('delete-brand-logo/{id}', [BrandController::class, 'deleteBrandLogo']);
        
        // banners
        Route::get('banners',[BannersController::class, 'banners']);
        Route::match(['get','post'], 'add-edit-banner/{id?}', [BannersController::class, 'addEditBanner']);
        Route::post('update-banner-status', [BannersController::class, 'updateBannerStatus']);
        Route::get('delete-banner/{id}', [BannersController::class, 'deleteBanner']);

    });
});

Route::get('dashboard', [DashboardController::class, 'dashboard_front']);
Route::match(['get', 'post'], '/user_login', [DashboardController::class, 'user_login']);
// Route::match(['get', 'post'], '/user_login', [DashboardController::class, 'create_login']);

