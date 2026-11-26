<?php

use App\Http\Controllers\Admin\AlbumController as AdminAlbumController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PhotoController as AdminPhotoController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SchoolLocationController as AdminSchoolLocationController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{album:slug}', [GalleryController::class, 'show'])->name('gallery.show');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Public interactions; authenticated accounts still pass the active check.
Route::middleware('active')->group(function () {
    Route::post('/photos/{photo}/like', [LikeController::class, 'store'])->name('photos.like');
    Route::delete('/photos/{photo}/like', [LikeController::class, 'destroy'])->name('photos.unlike');
    Route::post('/photos/{photo}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/photos/{photo}/reports', [ReportController::class, 'store'])->name('reports.store');
});

// Authenticated user routes
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('albums', AdminAlbumController::class)->except(['show']);

    Route::post('photos/bulk', [AdminPhotoController::class, 'bulkStore'])->name('photos.bulk-store');
    Route::resource('photos', AdminPhotoController::class)->except(['show']);

    Route::get('comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::patch('comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::patch('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
    Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
    Route::patch('reports/{report}', [AdminReportController::class, 'update'])->name('reports.update');
    Route::delete('reports/{report}', [AdminReportController::class, 'destroy'])->name('reports.destroy');

    Route::resource('users', AdminUserController::class)->except(['show']);
    Route::resource('school-locations', AdminSchoolLocationController::class)
        ->except(['show'])
        ->parameters(['school-locations' => 'location']);

    Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings.index');
});
