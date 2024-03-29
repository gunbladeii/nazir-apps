<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Models\Role;
use App\Http\Controllers\FormBuilderController;

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
});


Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-dashboard', [UserController::class, 'index'])->name('user');
    Route::get('/changePassword', [UserController::class, 'pagePassword'])->name('user');
    Route::get('/formBuilder', [UserController::class, 'formBuilder'])->name('user');
    Route::get('/paparInstrumen', [UserController::class, 'showInstruments'])->name('user.instruments');
});

Route::patch('/user/{user}/role', [AdminController::class, 'updateRole'])->name('admin.updateRole');
Route::get('/control', [AdminController::class, 'control'])->middleware('auth');
Route::get('/admin-dashboard', [AdminController::class, 'index'])->middleware('auth');

Route::post('/user/{user}/update-name', [AdminController::class, 'updateName'])->name('admin.updateName');
Route::post('/admin/add-user', [AdminController::class, 'addUser'])->name('admin.add-user');
Route::post('/user/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
Route::get('/form-builder', [FormBuilderController::class, 'index'])->name('form-builder.index');
// For storing new forms
Route::post('/form-builder/store/{formId?}', [FormBuilderController::class, 'store'])->name('form-builder.store');
// For updating existing forms
Route::post('/form-builder/update/{formId}', [FormBuilderController::class, 'update'])->name('form-builder.update');
// Add a route for updating the form
Route::put('/form/update/{form}', [FormBuilderController::class, 'update'])->name('form.update');
Route::post('/form/update/{formId}', [FormBuilderController::class, 'update'])->name('form.update');
//instrumen
Route::get('/instrumen/form', 'InstrumenPenilaianController@showForm');
Route::post('/instrumen/store', 'InstrumenPenilaianController@storeForm');
Route::put('/instrumen/update/{id}', 'InstrumenPenilaianController@updateForm');
