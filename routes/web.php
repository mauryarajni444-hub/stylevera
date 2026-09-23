<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\{GameController,
    HomeController,
    ShopController,
    ProductController,
    CartController,
    CheckoutController,
    WishlistController,
    ContactController,
    PageController,
    AccountController};

use App\Http\Controllers\Admin\{
    AdminDashboardController,
    AdminProductController,
    AdminCategoryController,
    AdminOrderController,
    AdminUserController,
    AdminCouponController,
    AdminBannerController,
    AdminSettingsController,
    AdminMediaController,
    AdminContactController
};

use App\Http\Controllers\Auth\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Language Switch
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }

    return back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::get('/cart/items', [CartController::class, 'items'])->name('cart.items');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'coupon'])->name('cart.coupon');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/order/confirm/{ref}', [CheckoutController::class, 'confirm'])->name('order.confirm');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter', [ContactController::class, 'newsletter'])->name('newsletter');

Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

/*
|--------------------------------------------------------------------------
| User Authentication
|--------------------------------------------------------------------------
*/





Route::middleware('guest')->group(function () {

    Route::get('/login', [AccountController::class, 'showLogin'])->name('login');
    Route::post('/login', [AccountController::class, 'login'])->name('login.post');

    Route::get('/register', [AccountController::class, 'showRegister'])->name('register');
    Route::post('/register', [AccountController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AccountController::class, 'logout'])->name('logout');

    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/orders/{ref}', [AccountController::class, 'orderDetail'])->name('account.order');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {

        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Panel
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('categories', AdminCategoryController::class)
            ->except('show');

        Route::post(
            'categories/{cat}/image',
            [AdminMediaController::class, 'uploadCategoryImage']
        )->name('categories.image');

        Route::resource('products', AdminProductController::class)
            ->except('show');

        Route::post(
            'products/{product}/cover',
            [AdminMediaController::class, 'uploadProductCover']
        )->name('products.cover');

        Route::post(
            'products/{product}/variants',
            [AdminProductController::class, 'storeVariant']
        )->name('products.variants.store');

        Route::get(
            'products/variants/{variant}/edit',
            [AdminProductController::class, 'editVariant']
        )->name('products.variants.edit');

        Route::put(
            'products/variants/{variant}',
            [AdminProductController::class, 'updateVariant']
        )->name('products.variants.update');

        Route::delete(
            'products/variants/{variant}',
            [AdminProductController::class, 'destroyVariant']
        )->name('products.variants.destroy');

        Route::get(
            'products/variants/{variant}/media-list',
            [AdminMediaController::class, 'getVariantMediaList']
        )->name('products.variants.media.list');

        Route::post(
            'products/variants/{variant}/media',
            [AdminMediaController::class, 'uploadVariantMedia']
        )->name('products.variants.media.upload');

        Route::post(
            'products/variants/media/{mediaId}/primary',
            [AdminMediaController::class, 'setVariantPrimary']
        )->name('products.variants.media.primary');

        Route::delete(
            'products/variants/media/{mediaId}',
            [AdminMediaController::class, 'destroyVariantMedia']
        )->name('products.variants.media.destroy');

        Route::resource('orders', AdminOrderController::class)
            ->only(['index', 'show', 'destroy']);

        Route::post(
            'orders/{order}/status',
            [AdminOrderController::class, 'updateStatus']
        )->name('orders.status');

        Route::get('coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
        Route::post('coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
        Route::delete('coupons/{c}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');

        Route::get('banners', [AdminBannerController::class, 'index'])->name('banners.index');
        Route::post('banners', [AdminBannerController::class, 'store'])->name('banners.store');
        Route::delete('banners/{b}', [AdminBannerController::class, 'destroy'])->name('banners.destroy');
        Route::post('banners/{b}/image', [AdminMediaController::class, 'uploadBannerImage'])->name('banners.image');

        Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::post('contacts/{c}/read', [AdminContactController::class, 'markRead'])->name('contacts.read');
        Route::delete('contacts/{c}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

        Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings');
        Route::post('settings', [AdminSettingsController::class, 'update'])->name('settings.update');

        /*
         | Master Admin Only
         */

        Route::middleware('sv.auth:master_admin')->group(function () {

            Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
            Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
            Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
            Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        });
    });

Route::middleware('sv.auth')->group(function () {
    Route::get('/game', [GameController::class, 'play'])->name('game.play');
    Route::get('/game/leaderboard', [GameController::class, 'leaderboard'])->name('game.leaderboard');
    Route::post('/game/score', [GameController::class, 'submitScore'])->name('game.score');
});

Route::get('/_envcheck', function () {
    return response()->json([
        'env' => app()->environment(),
        'app_url' => config('app.url'),
        'is_secure' => request()->isSecure(),
        'forwarded_proto' => request()->header('X-Forwarded-Proto'),
        'sample_asset' => asset('css/vendor.css'),
    ]);
});
