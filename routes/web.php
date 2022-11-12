<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnumerationController;
use App\Http\Controllers\History\MaidController as HistoryMaidController;
use App\Http\Controllers\Master\Maid\MaidController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TakenController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\Transaction\Maid\MaidController as TransactionMaidController;
use App\Http\Controllers\User\MaidController as UserMaidController;
use App\Http\Controllers\User\WorkerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMenuController;
use App\Http\Controllers\Utils\DropdownController;
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
    Route::get('/master/maids/get-data-maid/{maid}', [MaidController::class, 'getDataMaid']);
    Route::get('/master/maids/register-maid', [MaidController::class, 'create']);
    Route::get('/master/maids/generate-counter', [MaidController::class, 'generateCounter']);
    Route::get('/master/maids/get-work-experience', [MaidController::class, 'getWorkExperience']);
    Route::get('/master/maids/get-work-experience/{id}/edit', [MaidController::class, 'editWorkExperience']);
    Route::get('/master/maids/get-work-feedback', [MaidController::class, 'getWorkFeedback']);
    Route::get('/master/maids/get-maid-skill', [MaidController::class, 'getEmployeeSkill']);
    Route::get('/master/maids/get-country', [MaidController::class, 'getCountry']);
    Route::get('/master/maids/download-data', [MaidController::class, 'downloadData']);
    Route::post('/master/maids/add-work-experience', [MaidController::class, 'storeWorkExperience']);
    Route::put('/master/maids/add-work-experience/{id}', [MaidController::class, 'updateWorkExperience']);
    Route::delete('/master/maids/get-work-experience/{id}', [MaidController::class, 'destroyWorkExperience']);
    Route::resource('/master/maids', MaidController::class);

    Route::get('/master/announcements/get-all-data', [AnnouncementController::class, 'getAllData']);
    Route::resource('/master/announcements', AnnouncementController::class);

    // history
    Route::get('/history/maids/get-all-data', [HistoryMaidController::class, 'getAllData']);
    Route::resource('/history/maids', HistoryMaidController::class);

    Route::resource('/taken/maids', TakenController::class);

    // User
    Route::get('/workers/bookmark', [UserMaidController::class, 'create']);
    Route::resource('/workers', UserMaidController::class);

    // User - My Worker
    Route::get('/my-workers/upload', [WorkerController::class, 'create']);
    Route::resource('/my-workers', WorkerController::class);

    // transaction
    Route::get('/transaction/maids/documents/{document}', [TransactionMaidController::class, 'document']);
    Route::resource('/transaction/maids', TransactionMaidController::class);

    // booking
    Route::resource('/booked/maids', BookingController::class);

    // timeline
    Route::resource('/timelines/maids', TimelineController::class);

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
        Route::get('/dropdown/get-month', 'month');
        Route::get('/dropdown/get-year', 'year');
        Route::get('/dropdown/get-agency', 'agency');
        Route::get('/dropdown/get-maids', 'maids');
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
