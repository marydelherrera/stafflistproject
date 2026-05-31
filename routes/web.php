<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/',          fn() => redirect('/login'));
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/register',  [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',   [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Admin-only Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth.check', 'admin.only'])->group(function () {
    Route::get('/admin/dashboard',          [AdminController::class, 'dashboard']);
    Route::get('/admin/users',              [UserController::class, 'userstable']);
    Route::post('/admin/users',             [UserController::class, 'addUser']);
    Route::post('/admin/users/{id}/update', [UserController::class, 'updateUser']);
    Route::post('/admin/users/{id}/delete', [UserController::class, 'deleteUser']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (admin + staff)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth.check'])->group(function () {
    Route::get('/profile',                   [UserController::class, 'showProfile']);  
    Route::post('/profile/update',           [UserController::class, 'updateProfile']);
    Route::post('/profile/change-password',  [UserController::class, 'changePassword']);
});