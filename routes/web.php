<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortalController;

// Student Portal Routes
Route::get('/', [PortalController::class, 'index'])->name('portal.index');
Route::post('/candidatura', [PortalController::class, 'submit'])->name('portal.submit');
Route::get('/candidatura/{id}/pdf', [PortalController::class, 'downloadPdf'])->name('candidatura.pdf');

// Admin Routes
Route::get('/admin/login', [PortalController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [PortalController::class, 'login']);
Route::post('/admin/logout', [PortalController::class, 'logout'])->name('admin.logout');

// Protected Admin Dashboard
Route::get('/admin/dashboard', [PortalController::class, 'adminDashboard'])->name('admin.dashboard');
Route::post('/admin/candidaturas/{candidatura}/status', [PortalController::class, 'updateStatus'])->name('admin.update-status');
Route::post('/admin/candidaturas/{candidatura}/docente', [PortalController::class, 'updateDocente'])->name('admin.update-docente');
Route::post('/admin/candidaturas/{candidatura}/reset-pin', [PortalController::class, 'resetPin'])->name('admin.reset-pin');
Route::put('/admin/candidaturas/{candidatura}', [PortalController::class, 'updateCandidatura'])->name('admin.update-candidatura');
Route::post('/admin/profile', [PortalController::class, 'updateProfile'])->name('admin.profile.update');
Route::post('/admin/users', [PortalController::class, 'createUser'])->name('admin.users.create');
Route::put('/admin/users/{user}', [PortalController::class, 'updateUser'])->name('admin.users.update');
Route::delete('/admin/users/{user}', [PortalController::class, 'deleteUser'])->name('admin.users.delete');

// Workspace Routes
use App\Http\Controllers\WorkspaceController;
Route::get('/workspace/login', [WorkspaceController::class, 'loginForm'])->name('workspace.login');
Route::post('/workspace/login', [WorkspaceController::class, 'login'])->name('workspace.login.submit');
Route::get('/workspace/{candidatura}/recuperar-pin', [WorkspaceController::class, 'recoverPinForm'])->name('workspace.recover-pin');
Route::post('/workspace/{candidatura}/recuperar-pin', [WorkspaceController::class, 'recoverPinSubmit'])->name('workspace.recover-pin.submit');
Route::get('/workspace/{id}', [WorkspaceController::class, 'index'])->name('workspace.index');
Route::post('/workspace/{id}/message', [WorkspaceController::class, 'storeMessage'])->name('workspace.message');
Route::get('/api/workspace/{id}/mensagens', [WorkspaceController::class, 'poll'])->name('workspace.poll');
Route::post('/workspace/{id}/fase', [WorkspaceController::class, 'actualizarFase'])->name('workspace.fase');
Route::post('/workspace/{id}/ficheiro', [WorkspaceController::class, 'uploadFicheiro'])->name('workspace.ficheiro');
Route::get('/workspace/ficheiro/{id}/download', [WorkspaceController::class, 'downloadFicheiro'])->name('workspace.ficheiro.download');
Route::get('/api/workspace/{id}/kanban', [WorkspaceController::class, 'getKanbanTasks'])->name('workspace.kanban.get');
Route::post('/api/workspace/{id}/kanban', [WorkspaceController::class, 'storeKanbanTask'])->name('workspace.kanban.store');
Route::put('/api/workspace/{id}/kanban/{taskId}', [WorkspaceController::class, 'updateKanbanTaskStatus'])->name('workspace.kanban.update');
