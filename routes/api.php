<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    CatalogController,
    CartController,
    WishlistController,
    OrderController,
    MiscController,
    GameController
};


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('api.locale')->get('/home', [CatalogController::class, 'home']);
Route::middleware('api.locale')->get('/categories', [CatalogController::class, 'categories']);
Route::middleware('api.locale')->get('/products', [CatalogController::class, 'products']);
Route::middleware('api.locale')->get('/products/{slug}', [CatalogController::class, 'show']);

Route::get('/settings', [CatalogController::class, 'settings']);
Route::get('/game/leaderboard', [GameController::class, 'leaderboard']);

Route::post('/contact', [MiscController::class, 'contact']);
Route::post('/newsletter', [MiscController::class, 'newsletter']);

// ── Cart & Checkout ──────────────────────────────────────────────
// 'api.optional' correctly identifies a logged-in user (so their cart
// is tied to their account) WITHOUT blocking guests — this is the fix
// for the "Your cart is empty" bug: previously these routes never ran
// any auth middleware at all, so logged-in users' carts were silently
// falling back to a brand-new random guest cart on every request.
Route::middleware('api.optional')->group(function () {
    Route::get('/cart', [CartController::class, 'show']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/update', [CartController::class, 'update']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/clear', [CartController::class, 'clear']);
    Route::post('/cart/coupon', [CartController::class, 'coupon']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
});

// Authenticated routes — require login
Route::middleware('api.auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);

    Route::post('/products/{id}/reviews', [CatalogController::class, 'addReview']);

    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{ref}', [OrderController::class, 'show']);

    Route::post('/game/score', [GameController::class, 'submitScore']);
    Route::get('/game/best', [GameController::class, 'myBest']);
});
