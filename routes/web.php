<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\LaunchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Middleware\AdminOnly;
use App\Http\Resources\api;
use App\Mail\AccountCreated;
use App\Models\Key;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Xammie\Mailbook\Mailbook;

Route::middleware('auth')->group(function () {
    /* Dashboard */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/check-device/{app_key}/{app_token}', [LaunchController::class, 'checkDevice'])->name('launch.check_device');
    Route::post('/launch', [LaunchController::class, 'launch'])->name('launch');
    

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* Admin Only */
    Route::middleware(AdminOnly::class)->group(function () {
        Route::post('/categories/update', [CategoryController::class, 'update'])->name('categories.update');
        
        Route::get('/schools', [SchoolController::class, 'index'])->name('schools');
        Route::post('/schools/store', [SchoolController::class, 'store'])->name('schools.store');
        Route::get('/schools/edit', [SchoolController::class, 'edit'])->name('schools.edit');
        Route::post('/schools/update', [SchoolController::class, 'update'])->name('schools.update');
        Route::delete('/schools/destroy/{id}', [SchoolController::class, 'destroy'])->name('schools.destroy');
        Route::get('/schools/info/{code}', [SchoolController::class, 'info'])->name('schools.info');
        Route::get('/schools/check_email/{email}', [SchoolController::class, 'checkEmail'])->name('schools.check_email');
        Route::get('/schools/check_kit/{school_id}/{kit_id}', [SchoolController::class, 'checkKit'])->name('schools.check_kit');
        Route::post('/schools/reset-password/{id}', [SchoolController::class, 'resetPassword'])->name('schools.reset_password');
        
        Route::post('/keys/reset/{id}', [KeyController::class, 'reset'])->name('keys.reset');
        Route::delete('/keys/destroy/{id}', [KeyController::class, 'destroy'])->name('keys.destroy');
    });
});

Route::get('/offline', function () {
    return Inertia::render('Offline');
});

require __DIR__.'/auth.php';
