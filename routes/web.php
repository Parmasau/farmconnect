<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\MarketplaceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LandingController;

// Public Routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/marketplace/search', [MarketplaceController::class, 'search'])->name('marketplace.search');
Route::get('/marketplace/category/{category:slug}', [MarketplaceController::class, 'category'])->name('marketplace.category');
Route::get('/marketplace/product/{product:slug}', [MarketplaceController::class, 'show'])->name('marketplace.show');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Profile Routes - Complete with password update
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('add');
        Route::patch('/update/{cart}', [App\Http\Controllers\CartController::class, 'update'])->name('update');
        Route::delete('/remove/{cart}', [App\Http\Controllers\CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('clear');
        Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [App\Http\Controllers\CartController::class, 'processCheckout'])->name('process');
    });

    // Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{user}/toggle', [App\Http\Controllers\Admin\UserController::class, 'toggleActive'])->name('users.toggle');
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
        Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    });

    // Farmer Routes
    Route::middleware('role:farmer')->prefix('farmer')->name('farmer.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Farmer\DashboardController::class, 'index'])->name('dashboard');
        
        // Products Management
        Route::resource('products', App\Http\Controllers\Farmer\ProductController::class);
        
        // Products Marketplace (Farmer to Farmer)
        Route::get('/products-marketplace', [App\Http\Controllers\Farmer\ProductController::class, 'marketplace'])->name('products.marketplace');
        Route::get('/products-view/{id}', [App\Http\Controllers\Farmer\ProductController::class, 'viewProduct'])->name('products.view');
        Route::get('/products-contact/{productId}', [App\Http\Controllers\Farmer\ProductController::class, 'contactSeller'])->name('products.contact');

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [App\Http\Controllers\Farmer\OrderController::class, 'index'])->name('index');
            Route::get('/{order}', [App\Http\Controllers\Farmer\OrderController::class, 'show'])->name('show');
            Route::post('/{order}/cancel', [App\Http\Controllers\Farmer\OrderController::class, 'cancel'])->name('cancel');
            Route::get('/{order}/track', [App\Http\Controllers\Farmer\OrderController::class, 'track'])->name('track');
            Route::get('/{order}/invoice', [App\Http\Controllers\Farmer\OrderController::class, 'invoice'])->name('invoice');
        });

        // Advice
        Route::resource('advice', App\Http\Controllers\Farmer\AdviceController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('/advice-agrovets', [App\Http\Controllers\Farmer\AdviceController::class, 'availableAgrovets'])->name('advice.agrovets');

        // Consultations
        Route::resource('consultations', App\Http\Controllers\Farmer\ConsultationController::class)->only(['index', 'create', 'store', 'show']);

        // Farmer Messages
        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('/', [App\Http\Controllers\Farmer\MessageController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Farmer\MessageController::class, 'create'])->name('create');
            Route::get('/{userId}', [App\Http\Controllers\Farmer\MessageController::class, 'show'])->name('show');
            Route::post('/{userId}', [App\Http\Controllers\Farmer\MessageController::class, 'send'])->name('send');
            Route::get('/unread/count', [App\Http\Controllers\Farmer\MessageController::class, 'unreadCount'])->name('unread');
        });

        // Analytics
        Route::get('/analytics', [App\Http\Controllers\Farmer\AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('/analytics/sales', [App\Http\Controllers\Farmer\AnalyticsController::class, 'sales'])->name('analytics.sales');
        Route::get('/analytics/products', [App\Http\Controllers\Farmer\AnalyticsController::class, 'products'])->name('analytics.products');
    });

    // Agrovet Routes
    Route::middleware('role:agrovet')->prefix('agrovet')->name('agrovet.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Agrovet\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', App\Http\Controllers\Agrovet\ProductController::class);
        Route::patch('/products/{product}/stock', [App\Http\Controllers\Agrovet\ProductController::class, 'updateStock'])->name('products.stock');

        Route::get('/orders', [App\Http\Controllers\Agrovet\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Agrovet\OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [App\Http\Controllers\Agrovet\OrderController::class, 'updateStatus'])->name('orders.status');

        Route::get('/advice', [App\Http\Controllers\Agrovet\AdviceController::class, 'index'])->name('advice.index');
        Route::get('/advice/{adviceRequest}', [App\Http\Controllers\Agrovet\AdviceController::class, 'show'])->name('advice.show');
        Route::post('/advice/{adviceRequest}/respond', [App\Http\Controllers\Agrovet\AdviceController::class, 'respond'])->name('advice.respond');

        Route::get('/consultations', [App\Http\Controllers\Agrovet\ConsultationController::class, 'index'])->name('consultations.index');
        Route::get('/consultations/{consultation}', [App\Http\Controllers\Agrovet\ConsultationController::class, 'show'])->name('consultations.show');
        Route::patch('/consultations/{consultation}/status', [App\Http\Controllers\Agrovet\ConsultationController::class, 'updateStatus'])->name('consultations.status');

        Route::get('/messages', [App\Http\Controllers\Agrovet\MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{farmer}', [App\Http\Controllers\Agrovet\MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{farmer}', [App\Http\Controllers\Agrovet\MessageController::class, 'send'])->name('messages.send');

        Route::get('/analytics', [App\Http\Controllers\Agrovet\AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('/agrovet-products', [App\Http\Controllers\Farmer\ProductController::class, 'agrovetProducts'])->name('products.agrovet');
    });
});