<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('user.dashboard');

// User Dashboard Route
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'role:user'])->name('user.dashboard');

Route::get('/about', function () {
    return Inertia::render('user/About');
})->name('user.about');

Route::get('/map', function () {
    return Inertia::render('user/Map');
})->name('user.map');

Route::get('/statistic', function () {
    return Inertia::render('user/Statistic');
})->name('user.statistic');

Route::get('/report', function () {
    return Inertia::render('user/Report');
})->name('user.report');

// Admin Dashboard Route
Route::get('admin/dashboard', function () {
    return Inertia::render('admin/Dashboard');
})->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
