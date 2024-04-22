<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscribeTransactionController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/details/{course:slug}', [HomeController::class, 'details'])->name('home.details');
Route::get('/category/{category:slug}', [HomeController::class, 'category'])->name('home.category');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('home.pricing');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [HomeController::class, 'checkout'])->middleware('role:student')->name('home.checkout');
    Route::post('/checkout', [HomeController::class, 'checkoutStore'])->middleware('role:student')->name('home.checkout.store');
    Route::get('/learning/{course}/{courseVideo}', [HomeController::class, 'learning'])->middleware('role:student')->name('home.learning');

    Route::prefix('admin')->name('admin.')->group(function(){
        Route::resource('categories', CategoryController::class)->middleware('role:owner');
        Route::resource('teachers', TeacherController::class)->middleware('role:owner');
        Route::resource('courses', CourseController::class)->middleware('role:owner|teacher');
        Route::resource('subscribe_transactions', SubscribeTransactionController::class)->middleware('role:owner');

        Route::get('/add/video/{course:id}', [CourseVideoController::class, 'create'])->middleware('role:owner|teacher')->name('course.add.video');
        Route::post('/add/video/{course:id}', [CourseVideoController::class, 'store'])->middleware('role:owner|teacher')->name('course.add.video.store');
        Route::resource('course_videos', CourseVideoController::class)->middleware('role:owner|teacher');
    });
});

require __DIR__.'/auth.php';
