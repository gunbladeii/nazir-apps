<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/user', function () {
    return view('user');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {
    return view('test');
});

Route::get('/app', function () {
    return view('layouts.app');
});

// Standard authentication routes provided by Laravel
Auth::routes();

// Additional reset routes if needed
Auth::routes(['reset' => true]);

// Admin routes, only accessible by users with the 'admin' role
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', 'AdminController@index')->name('admin');
    // ... more admin routes
});

// User routes, only accessible by users with the 'user' role
Route::middleware(['role:user'])->group(function () {
    // Should be user-specific routes here, not admin
    Route::get('/user', 'UserController@index')->name('user');
    // ... more user routes
});

