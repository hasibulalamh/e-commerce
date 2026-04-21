<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\frontend\BrandController as FrontendBrandController;
use App\Http\Controllers\frontend\CustomerController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\frontend\PasswordResetController;
use App\Http\Controllers\frontend\ProductController as FrontendProductController;
use App\Http\Controllers\frontend\SocialAuthController;
use App\Http\Controllers\frontend\WishlistController;
use App\Http\Controllers\frontend\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('Home');

// Customer auth
Route::get('/customer/register', [CustomerController::class, 'register'])->name('customer.register');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store')->middleware('throttle:3,1');
Route::get('/customer/login', [CustomerController::class, 'login'])->name('customer.login');
Route::post('/customer/login/submit', [CustomerController::class, 'loginSubmit'])->name('customer.login.submit')->middleware('throttle:5,1');

// OTP Verification
Route::get('/customer/verify-otp', [CustomerController::class, 'showOtpForm'])->name('customer.verify.otp');
Route::post('/customer/verify-otp', [CustomerController::class, 'verifyOtp'])->name('customer.verify.otp.submit');
Route::get('/customer/resend-otp', [CustomerController::class, 'resendOtp'])->name('customer.resend.otp');

// 2FA Verification
Route::get('/customer/two-factor', [CustomerController::class, 'show2faForm'])->name('customer.2fa.verify');
Route::post('/customer/two-factor', [CustomerController::class, 'verify2fa'])->name('customer.2fa.verify.submit');

// Forgot / Reset Password
Route::get('/customer/password/forgot', [PasswordResetController::class, 'showForgotForm'])->name('customer.password.forgot');
Route::post('/customer/password/send', [PasswordResetController::class, 'sendResetLink'])->name('customer.password.send');
Route::get('/customer/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('customer.password.reset');
Route::post('/customer/password/update', [PasswordResetController::class, 'resetPassword'])->name('customer.password.update');

// Social Login
Route::get('/customer/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('customer.auth.google');
Route::get('/customer/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
// Route::get('/customer/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('customer.auth.facebook');
// Route::get('/customer/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

// Frontend pages
Route::get('/Brand', [FrontendBrandController::class, 'brand'])->name('customer.brand');
Route::get('/Brand/Items/{id}', [FrontendBrandController::class, 'brands'])->name('customer.brands');

// Product single page
Route::get('/product/details/{id}', [FrontendProductController::class, 'view'])->name('product.details');

// Product list page
Route::get('/product/list', [FrontendProductController::class, 'listview'])->name('product.listview');

// Customer protected routes
Route::group(['middleware' => 'customerg'], function () {
    Route::get('/addtocart/{product}', [OrderController::class, 'addtocart'])->name('addto.cart');
    Route::delete('/cart/remove/{id}', [OrderController::class, 'removecart'])->name('cart.remove');
    Route::post('/cart/update', [OrderController::class, 'updatecart'])->name('cart.update');
    Route::post('/customer/logout', [CustomerController::class, 'logout'])->name('customer.logout');
    Route::get('/cart/view', [OrderController::class, 'view'])->name('cart.view');
    Route::get('cart/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');
    
    // Customer Profile & Orders
    Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::post('/customer/profile/update', [CustomerController::class, 'profileupdate'])->name('customer.profile.update');
    Route::get('/customer/orders', [OrderController::class, 'myorders'])->name('customer.orders');
    Route::get('/customer/orders/{id}', [OrderController::class, 'orderdetail'])->name('customer.order.detail');
    
    // Address Management
    Route::get('/customer/addresses', [CustomerController::class, 'addresses'])->name('customer.addresses');
    Route::post('/customer/addresses/store', [CustomerController::class, 'addressStore'])->name('customer.address.store');
    Route::get('/customer/addresses/edit/{id}', [CustomerController::class, 'addressEdit'])->name('customer.address.edit');
    Route::post('/customer/addresses/update/{id}', [CustomerController::class, 'addressUpdate'])->name('customer.address.update');
    Route::delete('/customer/addresses/delete/{id}', [CustomerController::class, 'addressDelete'])->name('customer.address.delete');
    Route::post('/customer/addresses/set-default/{id}', [CustomerController::class, 'addressSetDefault'])->name('customer.address.default');
    
    Route::post('/placeorder/store', [OrderController::class, 'storeaddorder'])->name('placeorder.store');
    Route::get('/order/confirmation/{id}', [OrderController::class, 'orderConfirmation'])->name('order.confirmation');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('customer.wishlist');
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('customer.wishlist.toggle');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('customer.wishlist.remove');

    // Reviews
    Route::post('/product/review', [ReviewController::class, 'store'])->name('customer.product.review');

    // Coupon Application
    Route::post('/coupon/collect/{id}', [\App\Http\Controllers\frontend\CouponController::class, 'collect'])->name('customer.coupon.collect');
    Route::post('/coupon/apply', [\App\Http\Controllers\frontend\CouponController::class, 'apply'])->name('customer.coupon.apply');
    Route::get('/coupon/remove', [\App\Http\Controllers\frontend\CouponController::class, 'remove'])->name('customer.coupon.remove');
    Route::get('/customer/vouchers', [CustomerController::class, 'vouchers'])->name('customer.vouchers');
});

// Public Search
Route::get('/search', [FrontendProductController::class, 'search'])->name('product.search');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

 // Admin Authentication
    Route::get('/login', [AuthController::class, 'login'])->name('login');
     Route::post('/submit', [AuthController::class, 'loginsubmit'])->name('login.submit')->middleware('throttle:5,1');

 Route::prefix('admin')->group(function () {

    // Protected routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        // Dashboard Routes - Multiple routes for same dashboard
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

        // Profile Routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        });

        // Category Routes
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'list'])->name('category.list');
            Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
            Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
            Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
            Route::post('/import', [CategoryController::class, 'import'])->name('category.import');
        });

        // Product Routes
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'list'])->name('product.list');
            Route::get('/create', [ProductController::class, 'create'])->name('product.create');
            Route::post('/store', [ProductController::class, 'store'])->name('product.store');
            Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
            Route::get('/view/{id}', [ProductController::class, 'view'])->name('product.view');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
            Route::post('/import', [ProductController::class, 'import'])->name('product.import');
        });

        // Brand Routes
        Route::prefix('brands')->group(function () {
            Route::get('/', [BrandController::class, 'list'])->name('brand.list');
            Route::get('/create', [BrandController::class, 'create'])->name('brand.create');
            Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
            Route::delete('/delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
            Route::post('/update/{id}', [BrandController::class, 'update'])->name('brand.update');
            Route::post('/import', [BrandController::class, 'import'])->name('brand.import');
        });

        // Order Management Routes
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderListController::class, 'list'])->name('orders.list');
            Route::get('/view/{id}', [OrderListController::class, 'show'])->name('order.view');
            Route::post('/status/update/{id}', [OrderListController::class, 'updateStatus'])->name('orders.status.update');
            Route::get('/{order}/status-history', [OrderListController::class, 'statusHistory'])->name('orders.status.history');
            Route::post('/{order}/confirm', [OrderListController::class, 'confirm'])->name('orders.confirm');
            Route::post('/{order}/cancel', [OrderListController::class, 'cancel'])->name('orders.cancel');
            Route::get('/bulk-update', [OrderListController::class, 'bulkUpdate'])->name('orders.bulk-update');
            Route::get('/export', [OrderListController::class, 'export'])->name('orders.export');
            Route::get('/invoice/{id}', [OrderListController::class, 'invoice'])->name('order.invoice');
        });

        // Banner Routes
        Route::prefix('banners')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('banner.list');
            Route::get('/create', [BannerController::class, 'create'])->name('banner.create');
            Route::post('/store', [BannerController::class, 'store'])->name('banner.store');
            Route::delete('/delete/{id}', [BannerController::class, 'delete'])->name('banner.delete');
            Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
            Route::post('/update/{id}', [BannerController::class, 'update'])->name('banner.update');
        });

        // Coupon Routes
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
    });
});
