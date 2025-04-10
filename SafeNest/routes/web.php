<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ApplicationController;

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


Route::get('/redirect-by-role', function () {
    $role = auth()->user()->role;

    return match($role) {
        'admin' => redirect()->route('admindashboard'),
        'customer' => redirect()->route('customerdashboard'),
        'underwriter' => redirect()->route('underwriterdashboard'),
        default => abort(403),
    };
})->middleware('auth');

// Admin route → views/admin/admindashboard.blade.php
Route::get('/admin/dashboard', fn() => view('admin.admindashboard'))
    ->middleware('role:admin')
    ->name('admindashboard');

// Customer route → views/customer/dashboard.blade.php
Route::get('/customer/dashboard', fn() => view('customer.dashboard'))
    ->middleware('role:customer')
    ->name('customerdashboard');

// Underwriter route → views/underwriter/dashboard.blade.php
Route::get('/underwriter/dashboard', fn() => view('underwriter.dashboard'))
    ->middleware('role:underwriter')
    ->name('underwriterdashboard');

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

//policy controller
Route::resource('policies', PolicyController::class);

//Application controller
Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');

Route::post('/applications/{id}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');

Route::post('/applications/{id}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');

Route::get('/mypolicies', function () {
    return view('customer.mypolicy');
})->name('mypolicies');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/*Auth::routes();*/

/*Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('dashboard');*/

Route::group(['middleware' => 'auth'], function () {
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::patch('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
/*Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('admin.dashboard');*/





Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

require __DIR__.'/auth.php';
