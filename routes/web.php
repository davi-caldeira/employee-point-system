<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CepController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (login, logout, etc.)
Auth::routes();

// Fallback home route (optional)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin routes (protected by 'auth' and 'admin' middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User Management (CRUD for employees)
    Route::get('/admin/users', [AdminController::class, 'indexUsers'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // View point records with filters
    Route::get('/admin/points', [AdminController::class, 'viewPoints'])->name('admin.points.index');
});

// Employee routes (protected by 'auth' middleware and throttled to 20 requests per minute)
Route::middleware(['auth', 'throttle:20,1'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::post('/employee/points/register', [EmployeeController::class, 'registerPoint'])->name('employee.registerPoint');
    Route::get('/employee/change-password', [EmployeeController::class, 'showChangePasswordForm'])->name('employee.changePasswordForm');
    Route::post('/employee/change-password', [EmployeeController::class, 'updatePassword'])->name('employee.updatePassword');
});

// (protected by 'auth' and throttled to 10 requests per minute)
Route::middleware(['auth', 'throttle:10,1'])->group(function () {
    Route::get('/api/cep/{cep}', [CepController::class, 'getCep'])->name('cep.get');
});
