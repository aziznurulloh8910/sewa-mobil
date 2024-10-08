<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController; // Tambahkan ini
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckSuperAdmin;
use App\Http\Controllers\CarReturnController;

// Redirect to login page
Route::get('/', function () {
    return redirect('login');
});

// Routes for guests
Route::group(['middleware' => 'guest'], function () {
    // Authentication routes
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Password reset routes
    Route::get('/forgot-password', [AuthController::class, 'forgot_password_view'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgot_password_post'])->name('forgot-password-post');
    Route::get('/reset-password/{token}', [AuthController::class, 'reset_password_view'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset_password_post'])->name('password.update');
});

// Routes for authenticated users
Route::group(['middleware' => 'auth'], function () {
    // Home route
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Car management routes
    Route::prefix('cars')->group(function () {
        Route::get('/', [CarController::class, 'index'])->name('car');
        Route::get('/data-table', [CarController::class, 'dataTable']);
        Route::post('/store', [CarController::class, 'store'])->name('car.store');
        Route::get('/{id}', [CarController::class, 'show'])->name('car.show');
        Route::put('/update/{id}', [CarController::class, 'update'])->name('car.update');
        Route::delete('/delete/{id}', [CarController::class, 'delete'])->name('car.delete');
    });

    // Rental management routes
    Route::prefix('rentals')->group(function () {
        Route::get('/', [RentalController::class, 'index'])->name('rental');
        Route::get('/data-table', [RentalController::class, 'dataTable']);
        Route::post('/store', [RentalController::class, 'store'])->name('rental.store');
        Route::get('/{id}', [RentalController::class, 'show'])->name('rental.show');
        Route::put('/update/{id}', [RentalController::class, 'update'])->name('rental.update');
        Route::delete('/delete/{id}', [RentalController::class, 'delete'])->name('rental.delete');
    });

    // User management routes
    Route::prefix('users')->middleware('CheckSuperAdmin::class')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::post('/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/detail/{id}', [UserController::class, 'detail'])->name('users.detail');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    });

    // Profile routes
    Route::get('/profile', function () {
        return view('users.profile');
    })->name('profile');
    Route::put('/update-profile/{id}', [AuthController::class, 'update_profile'])->name('users.update.profile');
    Route::delete('/delete-account/{id}', [AuthController::class, 'delete_account_at_profile'])->name('users.delete.profile');

    // Logout route
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

    // Car return routes
    Route::prefix('car-returns')->middleware('auth')->group(function () {
        Route::get('/', [CarReturnController::class, 'index'])->name('car-return');
        Route::post('/store', [CarReturnController::class, 'store'])->name('car-return.store');
    });
});
