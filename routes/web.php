<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventBrowseCMController;
use App\Http\Controllers\RegistrationCMController;
use App\Http\Controllers\Admin\CategoryCMController as AdminCategoryController;
use App\Http\Controllers\Admin\EventCMController as AdminEventController;
use App\Http\Controllers\Admin\RegistrationCMController as AdminRegistrationController;
use App\Http\Controllers\AuthCMController;

Route::get('/', [EventBrowseCMController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventBrowseCMController::class, 'show'])->name('eventDetail');

Route::middleware('auth')->group(function () {
    Route::post('/events/{event}/register', [RegistrationCMController::class, 'store'])->name('events.register');
    Route::delete('/events/{event}/register', [RegistrationCMController::class, 'destroy'])->name('events.unregister');
    Route::get('/my/registrations', [RegistrationCMController::class, 'index'])->name('my.registrations');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('events', AdminEventController::class);
    Route::put('events/{event}/archive', [AdminEventController::class, 'archive'])->name('events.archive');
    Route::get('registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('profile', function () {
        return view('admin.profileCM');
    })->name('profile');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthCMController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthCMController::class, 'login']);
    Route::get('/register', [AuthCMController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthCMController::class, 'register']);
});
Route::post('/logout', [AuthCMController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/profile', function () {
    return view('profileCM');
})->middleware('auth')->name('profile');
