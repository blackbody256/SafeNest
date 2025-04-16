<?php

//namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApprovedPolicyController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\QuoteController;
//use App\Http\Controllers\CustomerClaimController;
use App\Http\Controllers\CustomerClaimController;


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

//Approved policy controller
Route::get('/approved-policies', [ApprovedPolicyController::class, 'index'])->name('approvedpolicies.index');
Route::post('/approved-policies/{applicationId}', [ApprovedPolicyController::class, 'store'])->name('approvedpolicies.store');

//claims controller
Route::get('/underwriter/claims', [ClaimController::class, 'index'])->name('claims.index');
Route::post('/underwriter/claims/{id}/update-status', [ClaimController::class, 'updateStatus'])->name('claims.updateStatus');

//quotes controller

// View all quotes (underwriter view)
Route::get('/underwriter/quotes', [QuoteController::class, 'index'])->name('quotes.index');

// Request a quote for a specific policy (simulate client request)
Route::post('/request-quote/{policyId}', [QuoteController::class, 'requestQuote'])->name('quotes.request');

// Optional: route to manually test calculation (for your testing)
Route::get('/test-quote', [QuoteController::class, 'testCalculation']);

//testing

Route::get('/test-quote/{userId}/{policyId}', function($userId, $policyId) {
    $controller = new QuoteController();
    return $controller->requestQuote($userId, $policyId);
});

//Customerclaim controller
Route::prefix('customer')->middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/claims', [CustomerClaimController::class, 'index'])->name('customer.claims.index');
    Route::get('/claims/create', [CustomerClaimController::class, 'create'])->name('customer.claims.create');
    Route::post('/claims', [CustomerClaimController::class, 'store'])->name('customer.claims.store');
});




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
