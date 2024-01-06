<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    return view('test');
});

Route::get('/app', function () {
    return view('layouts.app');
});

Auth::routes();

Auth::routes(['reset' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['role:admin'])->group(function () {
    // Only 'admin' role users can access these routes
    Route::get('/admin', 'AdminController@index')->name('admin');
    // ... more admin routes
});

Route::middleware(['role:user'])->group(function () {
    // Only 'admin' role users can access these routes
    Route::get('/admin', 'AdminController@index')->name('user');
    // ... more admin routes
});
