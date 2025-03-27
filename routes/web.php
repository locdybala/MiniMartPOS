<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\SupplierController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ImportOrderController;
use App\Http\Controllers\admin\InventoryController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\CustomerGroupController;
use App\Http\Controllers\admin\CustomerController;


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
    return view('index');
});


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Danh mục
    Route::middleware(['auth'])->group(function () {
        Route::prefix('categories')->group(function () {
            Route::get('/index', [CategoryController::class, 'index'])->name('categories.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
            Route::post('/add-category', [CategoryController::class, 'store'])->name('categories.store');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
            Route::post('/update-category', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });
        Route::prefix('brands')->group(function () {
            Route::get('/index', [BrandController::class, 'index'])->name('brands.index');
            Route::get('/create', [BrandController::class, 'create'])->name('brands.create');
            Route::post('/add-brand', [BrandController::class, 'store'])->name('brands.store');
            Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
            Route::post('/update-brand', [BrandController::class, 'update'])->name('brands.update');
            Route::delete('/delete/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
        });

        Route::prefix('suppliers')->group(function () {
            Route::get('/index', [SupplierController::class, 'index'])->name('suppliers.index');
            Route::get('/create', [SupplierController::class, 'create'])->name('suppliers.create');
            Route::post('/add-brand', [SupplierController::class, 'store'])->name('suppliers.store');
            Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
            Route::post('/update-brand', [SupplierController::class, 'update'])->name('suppliers.update');
            Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
        });

        Route::resource('products', ProductController::class)->middleware('auth');

        Route::resource('import-orders', ImportOrderController::class);
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

        Route::get('/low-stock-notifications', [InventoryController::class, 'getLowStockNotifications']);
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::resource('customer_groups', CustomerGroupController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('orders', OrderController::class);
        Route::get('/getCustomers', [CustomerController::class, 'getCustomers']);
    });
});


require __DIR__.'/auth.php';
