<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('user.dashboard');

// User Dashboard Route
Route::get('user/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'role:user'])->name('user.dashboard');

// Admin Dashboard Route
Route::get('admin/dashboard', function () {
    return Inertia::render('admin/Dashboard');
})->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
