<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// Home page
Route::get('/', function () {
    // If the user is already logged in…
    if (Auth::check()) {
        // Send admins to their dashboard…
        if (Auth::user()->role_id === 1) {
            return redirect()->route('admin.dashboard');
        }
        // …and students to /todo
        return redirect()->route('todo.index');
    }
    // Otherwise send guests to login
    return redirect()->route('login');
});

// Auth routes (login, registration, logout)
Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Two-Factor Routes
//Show 2FA challenge page
Route::get('/two-factor-challenge', [TwoFactorController::class, 'index'])->name('two-factor.login');
//Handle submitted code
Route::post('/two-factor-challenge', [TwoFactorController::class, 'store'])->name('two-factor.store');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::patch('users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
    Route::get('users/{user}/todos', [AdminController::class, 'userTodos'])->name('todos');
    Route::delete('users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

// Group routes that require auth
Route::middleware(['auth'])->group(function () {

    // To-Do Routes
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
    Route::delete('/todo/{todo}', [TodoController::class, 'destroy'])->name('todo.show');
    Route::get('/todo/{todo}/edit', [TodoController::class, 'edit'])->name('todo.edit');
    Route::put('/todo/{todo}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('/todo/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');

    // Profile Routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
