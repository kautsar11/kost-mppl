<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\User\ComplaintController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'user.landing_page')->name('user.landing_page');

Route::middleware('guest')->controller(LoginController::class)->group(function () {
    Route::get('login', 'create')->name('login');
    Route::post('login', 'authenticate')->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'signOut'])->name('logout');

    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile/{user}/edit', 'edit')->name('profile.edit');
        Route::patch('profile/{user}', 'update')->name('profile.update');
    });
    // user access
    // complaints page
    Route::controller(ComplaintController::class)->group(function () {
        Route::get('user/complaints', 'index')->name('user.complaints');
        Route::get('user/complaint/create', 'create')->name('user.complaint.create');
        Route::post('user/complaint/store', 'store')->name('user.complaint.store');
        Route::get('user/complaint/{complaint}/edit', 'edit')->name('user.complaint.edit');
        Route::patch('user/complaint/{complaint}', 'update')->name('user.complaint.update');
        Route::delete('user/complaint/{complaint}', 'destroy')->name('user.complaint.destroy');
    });

    // admin access
    Route::prefix('admin')->group(function () {

        // users page
        Route::controller(UserController::class)->group(function () {
            Route::get('users', 'index')->name('admin.users');
            Route::get('user/create', 'create')->name('admin.user.create');
            Route::post('user/store', 'store')->name('admin.user.store');
            Route::get('user/{user}/edit', 'edit')->name('admin.user.edit');
            Route::patch('user/{user}', 'update')->name('admin.user.update');
            Route::delete('user/{user}', 'destroy')->name('admin.user.destroy');
        });

        // rooms page
        Route::controller(RoomController::class)->group(function () {
            Route::get('rooms', 'index')->name('admin.rooms');
            Route::get('room/create', 'create')->name('admin.room.create');
            Route::post('room/store', 'store')->name('admin.room.store');
            Route::get('room/{room}/edit', 'edit')->name('admin.room.edit');
            Route::patch('room/{room}', 'update')->name('admin.room.update');
            Route::delete('room/{room}', 'destroy')->name('admin.room.destroy');
            Route::patch('room/clear/{room}', 'clear_the_room')->name('admin.room.clear');
        });

        // complaints page
        Route::controller(AdminComplaintController::class)->group(function () {
            Route::get('complaints', 'index')->name('admin.complaints');
            Route::patch('complaint/{complaint}/process', 'process')->name('admin.complaint.process');
            Route::patch('complaint/{complaint}/finished', 'finished')->name('admin.complaint.finished');
        });

        // Invoices page
        Route::controller(AdminComplaintController::class)->group(function () {

        });

    });




});
