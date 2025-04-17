<?php

//namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\PolicyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UnderwriterController;
use App\Http\Controllers\Admin\ClaimsController;
use App\Http\Controllers\Admin\PoliciesController; // Ensure this matches the actual namespace of the PoliciesController class
use App\Http\Controllers\Admin\PaymentController;

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApprovedPolicyController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\QuoteController;
//use App\Http\Controllers\CustomerClaimController;
use App\Http\Controllers\CustomerClaimController;
use App\Http\Controllers\PolicyCatalogueController; 
use App\Http\Controllers\ApplicationReviewController;
use App\Http\Controllers\UnderwriterDashboardController;


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



// Andrew's policy Catalogue Routes not touch.
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/policy-catalogue', [PolicyCatalogueController::class, 'index'])->name('policy.catalogue');
    Route::get('/policy-catalogue/{id}/apply', [PolicyCatalogueController::class, 'showApplicationForm'])->name('policy.application.form');
    Route::post('/policy-catalogue/{id}/apply', [PolicyCatalogueController::class, 'submitApplication'])->name('policy.application.submit');
    Route::get('/my-applications', [PolicyCatalogueController::class, 'myApplications'])->name('my.applications');
    // Add this new route
    Route::get('/my-applications/{id}', [PolicyCatalogueController::class, 'viewApplication'])->name('application.details');
    Route::post('/request-quote', [QuoteController::class, 'store'])->name('quotes.request');

});






Route::get('/mypolicies', [ApprovedPolicyController::class, 'userPolicies'])
    ->middleware(['auth', 'role:customer'])
    ->name('mypolicies');







//God i just pray that i will be able to resolve all the conflicts.
// Application Review Routes (for Underwriters)
Route::middleware(['auth', 'role:underwriter'])->group(function () {
    Route::get('/applications', [ApplicationReviewController::class, 'index'])->name('applications.index');
    Route::get('/applications/{id}', [ApplicationReviewController::class, 'show'])->name('applications.show');
    Route::get('/applications/{id}/download', [ApplicationReviewController::class, 'downloadDocuments'])->name('applications.download');
    Route::post('/applications/{id}/approve', [ApplicationReviewController::class, 'approve'])->name('applications.approve');
    Route::post('/applications/{id}/reject', [ApplicationReviewController::class, 'reject'])->name('applications.reject');
    Route::get('/underwriter/quotes', [QuoteController::class, 'index'])->name('underwriter.quotes.index');
    Route::delete('/underwriter/quote/{id}', [QuoteController::class, 'destroy'])->name('underwriter.quotes.index.delete');
    Route::delete('/underwriter/quotes/expired', [QuoteController::class, 'destroyExpired'])->name('underwriter.quotes.index.deleteExpired');
   
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
// Admin routes    
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/claims', [ClaimsController::class, 'index'])->name('admin.claims');
    Route::get('/policies', [PoliciesController::class, 'index'])->name('admin.policies');
    Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments');

    // Underwriter management (CRUD)
    //Route::resource('underwriters', UnderwriterController::class);
    Route::resource('underwriters', UnderwriterController::class)->names([
        'index' => 'admin.underwriters.index',
        'create' => 'admin.underwriters.create',
        'store' => 'admin.underwriters.store',
        'edit' => 'admin.underwriters.edit',
        'update' => 'admin.underwriters.update',
        'destroy' => 'admin.underwriters.destroy',
        'show' => 'admin.underwriters.show',
    ]);
});

// Customer route → views/customer/dashboard.blade.php
Route::get('/customer/dashboard', fn() => view('customer.dashboard'))
    ->middleware('role:customer')
    ->name('customerdashboard');
    

// Underwriter route → views/underwriter/dashboard.blade.php
Route::get('/underwriter/dashboard', [UnderwriterDashboardController::class, 'index'])
    ->middleware('auth', 'role:underwriter')
    ->name('underwriterdashboard');


/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

//policy controller
Route::resource('policies', PolicyController::class);

// Add a route to view policy details
Route::get('/policies/{id}', [PolicyController::class, 'show'])
    ->middleware(['auth'])
    ->name('policies.show');

// //Application controller
// Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');


//Approved policy controller
Route::get('/approved-policies', [ApprovedPolicyController::class, 'index'])->name('approvedpolicies.index');
Route::post('/approved-policies/{applicationId}', [ApprovedPolicyController::class, 'store'])->name('approvedpolicies.store');

//claims controller
Route::get('/underwriter/claims', [ClaimController::class, 'index'])->name('claims.index');
Route::post('/underwriter/claims/{id}/update-status', [ClaimController::class, 'updateStatus'])->name('claims.updateStatus');


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




// Route::post('/applications/{id}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
});





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/*Auth::routes();*/

/*Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('dashboard');*/

// Route::group(['middleware' => 'auth'], function () {
// 	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
// 	Route::patch('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
// 	Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
// });

/*Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('admin.dashboard');*/





Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});



require __DIR__.'/auth.php';
