<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', function () {
    return view('login');
});

Auth::routes();

Route::get('/home', function () {
    // Redirect to the appropriate dashboard based on the role
    if (Auth::user()->roles->contains('name', 'admin')) {
        return redirect('/admin-dashboard');
    } else {
        return redirect('/user-dashboard');
    }
})->middleware('auth');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin');
    Route::get('/control', [AdminController::class, 'control'])->name('admin');
    Route::get('/daftar', [AdminController::class, 'daftar'])->name('admin');
});


Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-dashboard', [UserController::class, 'index'])->name('user');
});

Route::patch('/user/{user}/role', [AdminController::class, 'updateRole'])->name('admin.updateRole');
Route::get('/control', [AdminController::class, 'control'])->middleware('auth');
Route::get('/admin-dashboard', [AdminController::class, 'index'])->middleware('auth');

