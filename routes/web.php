<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ресурсы доступны всем для просмотра (index, show), но защищены для создания/изменения
Route::resource('task_statuses', TaskStatusController::class)->except(['show']);
Route::resource('tasks', TaskController::class);
Route::resource('labels', LabelController::class);

// Защищаем только опасные методы ресурсов:
Route::middleware('auth')->group(function () {
    Route::resource('task_statuses', TaskStatusController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('tasks', TaskController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('labels', LabelController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});

require __DIR__ . '/auth.php';
