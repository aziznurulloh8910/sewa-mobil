<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/forgot-password', [AuthController::class, 'forgot_password_view'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgot_password_post'])->name('forgot-password-post');
    Route::get('/reset-password/{token}', [AuthController::class, 'reset_password_view'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset_password_post'])->name('password.update');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // mengelola data aset
    Route::get('/asset', [AsetController::class, 'index'])->name('asset');
    Route::get('/asset-data-table', [AsetController::class, 'dataTable']);
    Route::post('/asset/store', [AsetController::class, 'store'])->name('asset.store');
    Route::get('/asset/{id}', [AsetController::class, 'show'])->name('asset.show');
    Route::put('/asset/update/{id}', [AsetController::class, 'update'])->name('asset.update');
    Route::delete('/asset/delete/{id}', [AsetController::class, 'delete'])->name('asset.delete');

    // mengelola data kriteria
    Route::get('/criteria', [CriteriaController::class, 'index'])->name('criteria');
    Route::get('/criteria-data-table', [CriteriaController::class, 'dataTable']);

    // mengelola data sub kriteria
    Route::get('/sub-criteria', function (){
        return view('subCriteria.index');
    })->name('sub-criteria');

    // mengelola data history penghapusan aset
    Route::get('/deletion-history', function (){
        return view('history.index');
    })->name('deletion-history');

    // mengelola data history penghapusan aset
    Route::get('/asset-procurement', function (){
        return view('procurement.index');
    })->name('asset-procurement');

    // mengelola data sub kriteria
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/detail/{id}', [UserController::class, 'detail'])->name('users.detail');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');

    Route::get('/profile', function () {
        return view('users.profile');
    })->name('profile');
    Route::put('/update-profile/{id}', [AuthController::class, 'update_profile'])->name('users.update.profile');
    Route::delete('/delete-account/{id}', [AuthController::class, 'delete_account_at_profile'])->name('users.delete.profile');

    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});
