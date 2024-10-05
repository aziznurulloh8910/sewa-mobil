<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckSuperAdmin;

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

    // Asset management routes
    Route::prefix('asset')->group(function () {
        Route::get('/', [AssetController::class, 'index'])->name('asset');
        Route::get('/data-table', [AssetController::class, 'dataTable']);
        Route::post('/store', [AssetController::class, 'store'])->name('asset.store');
        Route::get('/{id}', [AssetController::class, 'show'])->name('asset.show');
        Route::put('/update/{id}', [AssetController::class, 'update'])->name('asset.update');
        Route::delete('/delete/{id}', [AssetController::class, 'delete'])->name('asset.delete');
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
});
