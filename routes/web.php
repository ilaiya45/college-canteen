<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSnackController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
//use App\Http\Controllers\SnackController;
use App\Http\Controllers\Student\SnackController;


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | STUDENT LOGIN
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.store');


    /*
    |--------------------------------------------------------------------------
    | STUDENT REGISTER
    |--------------------------------------------------------------------------
    */

    Route::get('/register', [RegisterController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'register'])
        ->name('register.store');


    /*
    |--------------------------------------------------------------------------
    | ADMIN LOGIN
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/login', [LoginController::class, 'showAdminLogin'])
        ->name('admin.login');

    Route::post('/admin/login', [LoginController::class, 'adminLogin'])
        ->name('admin.login.store');


    /*
    |--------------------------------------------------------------------------
    | FORGOT PASSWORD
    |--------------------------------------------------------------------------
    */

    Route::get('/forgot-password', [
        ForgotPasswordController::class,
        'showForgotPassword'
    ])->name('password.request');

    Route::post('/forgot-password', [
        ForgotPasswordController::class,
        'sendResetLink'
    ])->name('password.email');


    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    Route::get('/reset-password/{token}', [
        ForgotPasswordController::class,
        'showResetPassword'
    ])->name('password.reset');

    Route::post('/reset-password', [
        ForgotPasswordController::class,
        'resetPassword'
    ])->name('password.store');

});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | STUDENT DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('students.dashboard');
    })->name('students.dashboard');


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        LoginController::class,
        'logout'
    ])->name('logout');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | FOOD
    |--------------------------------------------------------------------------
    */

    Route::get('/food', [
        SnackController::class,
        'index'
    ])->name('food.index');


    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    Route::get('/cart', [
        CartController::class,
        'index'
    ])->name('cart.index');

    Route::post('/cart/add/{snack}', [
        CartController::class,
        'add'
    ])->name('cart.add');

    Route::post('/cart/increase/{id}', [
        CartController::class,
        'increase'
    ])->name('cart.increase');

    Route::post('/cart/decrease/{id}', [
        CartController::class,
        'decrease'
    ])->name('cart.decrease');

    Route::delete('/cart/remove/{id}', [
        CartController::class,
        'remove'
    ])->name('cart.remove');


    /*
    |--------------------------------------------------------------------------
    | ORDERS
    |--------------------------------------------------------------------------
    */

    Route::post('/orders', [
        OrderController::class,
        'store'
    ])->name('orders.store');

    Route::get('/orders', [
        OrderController::class,
        'index'
    ])->name('orders.index');

    Route::get('/orders/payment', [OrderController::class, 'payment'])
    ->name('orders.payment');

    Route::post('/orders/payment', [OrderController::class, 'submitPayment'])
    ->name('orders.payment.submit');

    Route::get('/orders/{order}', [
        OrderController::class,
        'show'
    ])->name('orders.show');



    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/dashboard', [
            AdminController::class,
            'dashboard'
        ])->name('admin.dashboard');

        Route::get(
    '/admin/orders/{order}/verify-payment',
    [AdminController::class, 'verifyPayment']
)->name('admin.orders.verify-payment');

Route::patch(
    '/admin/orders/{order}/payment/confirm',
    [AdminController::class, 'confirmPayment']
)->name('admin.orders.confirm-payment');

Route::patch(
    '/admin/orders/{order}/payment/reject',
    [AdminController::class, 'rejectPayment']
)->name('admin.orders.reject-payment');


        /*
        |--------------------------------------------------------------------------
        | ADMIN ORDER MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::patch('/admin/orders/{order}/status', [
            AdminController::class,
            'updateStatus'
        ])->name('admin.orders.updateStatus');

        Route::post('/admin/orders/verify', [
            AdminController::class,
            'verifyOrder'
        ])->name('admin.orders.verify');


        /*
        |--------------------------------------------------------------------------
        | ADMIN SNACK MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/snacks', [
            AdminSnackController::class,
            'index'
        ])->name('admin.snacks.index');

        Route::get('/admin/snacks/create', [
            AdminSnackController::class,
            'create'
        ])->name('admin.snacks.create');

        Route::post('/admin/snacks', [
            AdminSnackController::class,
            'store'
        ])->name('admin.snacks.store');

        Route::get('/admin/snacks/{snack}/edit', [
            AdminSnackController::class,
            'edit'
        ])->name('admin.snacks.edit');

        Route::put('/admin/snacks/{snack}', [
            AdminSnackController::class,
            'update'
        ])->name('admin.snacks.update');

        Route::delete('/admin/snacks/{snack}', [
            AdminSnackController::class,
            'destroy'
        ])->name('admin.snacks.destroy');

        Route::patch('/admin/snacks/{snack}/availability', [
            AdminSnackController::class,
            'toggleAvailability'
        ])->name('admin.snacks.toggleAvailability');

    });

});
