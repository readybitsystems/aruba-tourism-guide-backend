<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('sessionAuthWeb')->prefix('/')->group(function () {
    Route::get('/', [LoginController::class, 'login_page'])->name('LoginPage');
    Route::post('/admin', [LoginController::class, 'login'])->name('LoginUser');
});

Route::middleware('sessionAuthWeb')->prefix('/admin/')->group(function () {
    // Users calls
    Route::get('edit-admin-profile', [UserController::class, 'editProfile'])->name('EditProfile');
    Route::post('update-admin-profile-admin', [UserController::class, 'updateProfile2'])->name('updateAdminProfile');
    Route::get('users', [UserController::class, 'index'])->name('GetUsers');
    Route::post('users', [UserController::class, 'index'])->name('GetUsers');
    Route::get('add-users-form', [UserController::class, 'addUserForm'])->name('CreateUser');
    Route::post('add-users', [UserController::class, 'store'])->name('AddUser');
    Route::post('user/update/{user}', [UserController::class, 'update'])->name('UpdateUser');
    Route::get('edit/user/{user}', [UserController::class, 'edit'])->name('EditUserPage');
    Route::post('user/status/{user}', [UserController::class, 'status'])->name('UserStatus');
    Route::get('user/destroy/{user}', [UserController::class, 'destroy'])->name('Userdestroy');
    Route::get('logout', [LoginController::class, 'logout'])->name('Logout');

    Route::get('dashboard', [LoginController::class, 'dashboard'])->name('Dashboard');
    // country calls
    Route::post('search-languages', [CountryController::class, 'index'])->name('searche-languages');
    Route::get('languages', [CountryController::class, 'index'])->name('getlanguagesall');

    Route::get('countries', [CountryController::class, 'index'])->name('GetCountries');
    Route::get('add-language', [CountryController::class, 'create'])->name('CreateCountriesPage');
    Route::post('update-country/{country}', [CountryController::class, 'update'])->name('UpdateCountry');
    Route::get('edit-language/{country}', [CountryController::class, 'edit'])->name('EditCountryPage');
    Route::post('add-country', [CountryController::class, 'store'])->name('AddCountry');
    Route::get('delete/country/{country}', [CountryController::class, 'destroy'])->name('DeleteCountry');


    //Tour calls
    Route::get('tours', [TourController::class, 'index'])->name('GetTours');
    Route::POST('tours', [TourController::class, 'index'])->name('GetTours');
    Route::get('create-tour', [TourController::class, 'create'])->name('CreateToursPage');
    Route::post('update-tour/{tour}', [TourController::class, 'update'])->name('UpdateTour');
    Route::get('edit-tour/{tour}', [TourController::class, 'edit'])->name('EditTourPage');
    Route::post('add-tour', [TourController::class, 'store'])->name('AddTour');
    Route::get('delete/tour/{tour}', [TourController::class, 'destroy'])->name('DeleteTour');
    

    //Places calls
    Route::get('places', [PlaceController::class, 'index'])->name('GetPlaces');
    Route::POST('places', [PlaceController::class, 'index'])->name('GetPlaces');
    Route::get('create-place', [PlaceController::class, 'create'])->name('CreatePlacesPage');
    Route::post('update-place/{place}', [PlaceController::class, 'update'])->name('UpdatePlace');
    Route::get('edit-place/{place}', [PlaceController::class, 'edit'])->name('EditplacePage');
    Route::post('add-place', [PlaceController::class, 'store'])->name('Addplace');
    Route::get('delete/place/{place}', [PlaceController::class, 'destroy'])->name('Deleteplace');
    Route::get('delete/place-image/{place_image_id}', [PlaceController::class, 'destroy_image'])->name('DeleteplaceImage');
});
