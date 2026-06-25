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
Route::put('/api/workspace/{id}/messages/{messageId}', [WorkspaceController::class, 'updateMessage'])->name('workspace.message.update');
Route::delete('/api/workspace/{id}/messages/{messageId}', [WorkspaceController::class, 'deleteMessage'])->name('workspace.message.delete');
Route::get('/api/workspace/{id}/mensagens', [WorkspaceController::class, 'poll'])->name('workspace.poll');
Route::post('/workspace/{id}/fase', [WorkspaceController::class, 'actualizarFase'])->name('workspace.fase');
Route::post('/workspace/{id}/ficheiro', [WorkspaceController::class, 'uploadFicheiro'])->name('workspace.ficheiro');
Route::delete('/workspace/{id}/ficheiro/{ficheiroId}', [WorkspaceController::class, 'deleteFicheiro'])->name('workspace.ficheiro.delete');
Route::get('/workspace/ficheiro/{id}/download', [WorkspaceController::class, 'downloadFicheiro'])->name('workspace.ficheiro.download');
Route::get('/workspace/ficheiro/{id}/preview', [WorkspaceController::class, 'previewFicheiro'])->name('workspace.ficheiro.preview');
Route::get('/api/workspace/{id}/kanban', [WorkspaceController::class, 'getKanbanTasks'])->name('workspace.kanban.get');
Route::post('/api/workspace/{id}/kanban', [WorkspaceController::class, 'storeKanbanTask'])->name('workspace.kanban.store');
Route::put('/api/workspace/{id}/kanban/{taskId}', [WorkspaceController::class, 'updateKanbanTaskStatus'])->name('workspace.kanban.update');
Route::delete('/api/workspace/{id}/kanban/{taskId}', [WorkspaceController::class, 'deleteKanbanTask'])->name('workspace.kanban.delete');
Route::post('/api/workspace/{id}/typing', [WorkspaceController::class, 'typing'])->name('workspace.typing');

// AI Routes
use App\Http\Controllers\AiController;
Route::post('/api/workspace/{id}/ai/suggest-tasks', [AiController::class, 'suggestTasks'])->name('workspace.ai.suggest');
Route::get('/api/workspace/{id}/ai/summarize', [AiController::class, 'summarize'])->name('workspace.ai.summarize');
Route::get('/api/workspace/{id}/ai/analyze-chat', [AiController::class, 'analyzeChat'])->name('workspace.ai.analyze');
Route::post('/api/workspace/{id}/ai/ask', [AiController::class, 'askAssistant'])->name('workspace.ai.ask');
Route::post('/api/workspace/{id}/ai/toggle-auto-reply', [AiController::class, 'toggleAutoReply'])->name('workspace.ai.toggle_auto_reply');

// Portal AI Routes
Route::post('/api/ai/suggest-idea', [AiController::class, 'suggestIdea'])->name('ai.suggest_idea');
