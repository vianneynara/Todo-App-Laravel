<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'showRegistrationPage'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/todos', [TodoController::class, 'showTodoPage'])->name('todos');
Route::post('/todos', [TodoController::class, 'create']);
Route::post('/todos/toggle', [TodoController::class, 'toggleCompletion']);
Route::post('/todos/delete', [TodoController::class, 'delete']);
// Route::delete('/todos/{todo_id}', [TodoController::class, 'delete']);