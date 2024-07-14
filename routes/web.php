<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SubCriteriaController;
use App\Http\Controllers\DeletionHistoryController;
use App\Http\Controllers\MaintenanceController;
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
        Route::get('/', [AsetController::class, 'index'])->name('asset');
        Route::get('/data-table', [AsetController::class, 'dataTable']);
        Route::post('/store', [AsetController::class, 'store'])->name('asset.store');
        Route::get('/{id}', [AsetController::class, 'show'])->name('asset.show');
        Route::put('/update/{id}', [AsetController::class, 'update'])->name('asset.update');
        Route::delete('/delete/{id}', [AsetController::class, 'delete'])->name('asset.delete');
    });

    // Criteria management routes
    Route::prefix('criteria')->middleware('CheckSuperAdmin')->group(function () {
        Route::get('/', [CriteriaController::class, 'index'])->name('criteria');
        Route::get('/data-table', [CriteriaController::class, 'dataTable']);
        Route::post('/store', [CriteriaController::class, 'store'])->name('criteria.store');
        Route::get('/{id}', [CriteriaController::class, 'show'])->name('criteria.show');
        Route::put('/update/{id}', [CriteriaController::class, 'update'])->name('criteria.update');
        Route::delete('/delete/{id}', [CriteriaController::class, 'delete'])->name('criteria.delete');
    });

    // Subcriteria management routes
    Route::prefix('subcriteria')->middleware('CheckSuperAdmin')->group(function () {
        Route::get('/', [SubCriteriaController::class, 'index'])->name('subcriteria');
        Route::post('/store', [SubCriteriaController::class, 'store'])->name('subcriteria.store');
        Route::get('/{id}', [SubCriteriaController::class, 'show'])->name('subcriteria.show');
        Route::put('/update/{id}', [SubCriteriaController::class, 'update'])->name('subcriteria.update');
        Route::delete('/delete/{id}', [SubCriteriaController::class, 'delete'])->name('subcriteria.delete');
    });

    // Evaluation routes
    Route::prefix('evaluation')->middleware('CheckSuperAdmin')->group(function () {
        Route::get('/', [EvaluationController::class, 'index'])->name('evaluation');
        Route::get('/data-table', [EvaluationController::class, 'dataTable']);
        Route::post('/store', [EvaluationController::class, 'store'])->name('evaluation.store');
        Route::get('/{id}/edit', [EvaluationController::class, 'edit'])->name('evaluation.edit');
    });

    // Process and ranking routes
    Route::get('/process', [EvaluationController::class, 'process'])->middleware('CheckSuperAdmin')->name('process');
    Route::get('/ranking', [EvaluationController::class, 'ranking'])->middleware('CheckSuperAdmin')->name('ranking');
    Route::get('/ranking/data-table', [EvaluationController::class, 'rankingDataTable'])->middleware('CheckSuperAdmin')->name('ranking.dataTable');

    // History routes
    Route::prefix('deletion-history')->group(function () {
        Route::get('/', [DeletionHistoryController::class, 'index'])->name('deletion-history');
        Route::get('/data-table', [DeletionHistoryController::class, 'dataTable'])->name('deletion-history.data-table');
        Route::post('/store', [DeletionHistoryController::class, 'store'])->name('deletion-history.store');
        Route::get('/{id}', [DeletionHistoryController::class, 'show'])->name('deletion-history.show');
        Route::put('/update/{id}', [DeletionHistoryController::class, 'update'])->name('deletion-history.update');
        Route::delete('/delete/{id}', [DeletionHistoryController::class, 'destroy'])->name('deletion-history.delete');
    });

    Route::get('/asset-procurement', function () {
        return view('procurement.index');
    })->name('asset-procurement');

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

    // Routes for deleting and maintaining assets
    Route::delete('/assets/{id}', [EvaluationController::class, 'deleteAsset']);
    Route::post('/assets/maintain/{id}', [EvaluationController::class, 'maintainAsset']);

    // Routes for maintenance
    Route::prefix('maintenance')->group(function () {
        Route::get('/', [MaintenanceController::class, 'index'])->name('maintenance');
        Route::get('/data-table', [MaintenanceController::class, 'dataTable']);
        Route::post('/store', [MaintenanceController::class, 'store'])->name('maintenance.store');
        Route::get('/{id}', [MaintenanceController::class, 'show'])->name('maintenance.show');
        Route::put('/update/{id}', [MaintenanceController::class, 'update'])->name('maintenance.update');
        Route::delete('/delete/{id}', [MaintenanceController::class, 'destroy'])->name('maintenance.delete');
    });
});