<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('sessionAuth')->group(function () {
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'store'])->name('register');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('forget/password', [LoginController::class, 'forgetPasswordEmail'])->name('forgetPasswordEmail');
    Route::post('verify/reset/password', [LoginController::class, 'forget_password_email_verification'])->name('forget_password_email_verification');
    Route::post('reset/password', [LoginController::class, 'resetPassword'])->name('resetPassword');
    Route::post('update/password', [LoginController::class, 'updatePassword']);

    Route::get('me', [UserController::class, 'me'])->name('MeCall');
    Route::get('account/delete/{user}', [UserController::class, 'destroy'])->name('deleteAccount');
    Route::post('update/profile', [UserController::class, 'updateProfile']);
    // Resource Route
    Route::resource('users', UserController::class);
    Route::resource('places', PlaceController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('tours', TourController::class);
    
    Route::get('get/all/data', [DashboardController::class, 'appData']);

    

    // image download
    Route::get('user-image/{user}', [UserController::class, 'userImage']);
    Route::get('country-image/{country}', [CountryController::class, 'countryImage']);

    // Routes with Prefix
    Route::middleware('superAdminAuth')->prefix('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('register', [UserController::class, 'storeUser']);
        Route::get('home', [DashboardController::class, 'homeManager']);
    });

    Route::middleware('employeeAuth')->prefix('employee')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('register', [UserController::class, 'storeUser']);
        Route::get('home', [DashboardController::class, 'homeManager']);
    });
});
