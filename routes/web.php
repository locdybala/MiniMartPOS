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
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\frontend\PostsController;
use App\Http\Controllers\frontend\ShopController;
use App\Http\Controllers\frontend\CustomerAuthController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\frontend\CheckoutController;
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

Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');
Route::get('/posts', [PostsController::class, 'index'])->name('posts_index');
Route::get('posts/detail', [PostsController::class, 'detail'])->name('post.detail');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/products/{id}', [ShopController::class, 'productDetails'])->name('product.details');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{id}', [ShopController::class, 'categoryList'])->name('shop.categoryList');
Route::post('/product/{id}/review', [ShopController::class, 'store'])->name('product.review');
Route::prefix('customer')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login.post');
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('customer.register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::get('/password/forgot', [CustomerAuthController::class, 'showForgotForm'])->name('customer.forgot');
    Route::post('/password/email', [CustomerAuthController::class, 'sendResetLink'])->name('customer.send_email');
});

Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/index', [CartController::class, 'viewCart'])->name('cart.index');
    Route::post('/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
    Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
});
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/success', function() {
        return view('frontend.checkout.success');
    })->name('checkout.success');
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
        Route::resource('customer', CustomerController::class);
        Route::resource('orders', OrderController::class);
        Route::get('/getCustomers', [CustomerController::class, 'getCustomers']);
        Route::resource('posts', PostController::class);

        Route::resource('admin/coupons', CouponController::class);
        Route::get('orders/{id}/edit-status', [OrderController::class, 'editStatus'])->name('orders.edit-status');
        Route::put('orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('orders.invoice');
    });
});


require __DIR__.'/auth.php';
