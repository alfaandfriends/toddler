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
    
    Route::post('/launch/status/{key}', [LaunchController::class, 'checkStatus'])->name('launch.check_status');
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
        Route::post('/schools/reset-password/{id}', [SchoolController::class, 'resetPassword'])->name('schools.reset_password');
        
        Route::post('/keys/reset/{id}', [KeyController::class, 'reset'])->name('keys.reset');
        Route::delete('/keys/destroy/{id}', [KeyController::class, 'destroy'])->name('keys.destroy');
    });
});

require __DIR__.'/auth.php';
