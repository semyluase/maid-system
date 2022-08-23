<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnumerationController;
use App\Http\Controllers\MaidController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMenuController;
use App\Http\Controllers\utils\DropdownController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index');
    });

    // master
    Route::get('/master/enumerations/get-all-data', [EnumerationController::class, 'getAllData']);
    Route::resource('/master/enumerations', EnumerationController::class);

    Route::get('/master/roles/get-all-data', [RoleController::class, 'getAllData']);
    Route::resource('/master/roles', RoleController::class);

    Route::get('/master/countries/get-all-data', [CountryController::class, 'getAllData']);
    Route::resource('/master/countries', CountryController::class);

    Route::get('/master/maids/get-all-data', [MaidController::class, 'getAllData']);
    Route::resource('/master/maids', MaidController::class);

    Route::get('/master/announcements/get-all-data', [AnnouncementController::class, 'getAllData']);
    Route::resource('/master/announcements', AnnouncementController::class);

    Route::controller(MenuController::class)->group(function () {
        Route::get('/master/menus/get-menu-tree', 'getMenuTree');
    });

    Route::get('/users/get-all-data', [UserController::class, 'getAllData']);
    Route::resource('/users', UserController::class);

    Route::get('/manage/menus/get-user-data', [UserMenuController::class, 'getUserData']);
    Route::resource('/manage/menus', UserMenuController::class);

    Route::get('/manage/profile', [UserController::class, 'myProfile']);
    Route::put('/manage/profile/change-password/{user}', [UserController::class, 'changePassword']);
    Route::put('/manage/profile/change-profile/{user}', [UserController::class, 'updateProfile']);

    // utils
    Route::controller(DropdownController::class)->group(function () {
        Route::get('/dropdown/get-role', 'role');
        Route::get('/dropdown/get-country', 'country');
        Route::get('/dropdown/get-province', 'province');
        Route::get('/dropdown/get-regency', 'regency');
        Route::get('/dropdown/get-district', 'district');
        Route::get('/dropdown/get-village', 'village');
    });

    // logout
    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout');
    });
});

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/do_login', 'authenticate');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
    });
});
