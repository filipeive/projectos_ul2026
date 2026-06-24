<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortalController;

// Student Portal Routes
Route::get('/', [PortalController::class, 'index'])->name('portal.index');
Route::post('/candidatar', [PortalController::class, 'submit'])->name('portal.submit');

// Admin Routes
Route::get('/admin/login', [PortalController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [PortalController::class, 'login']);
Route::post('/admin/logout', [PortalController::class, 'logout'])->name('admin.logout');

// Protected Admin Dashboard
Route::get('/admin/dashboard', [PortalController::class, 'adminDashboard'])->name('admin.dashboard');
Route::post('/admin/candidaturas/{candidatura}/status', [PortalController::class, 'updateStatus'])->name('admin.update-status');
