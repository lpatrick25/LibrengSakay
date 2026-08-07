<?php

use App\Http\Controllers\ApplicantManagementController;
use App\Http\Controllers\ApplicantRegistrationController;
use App\Http\Controllers\ApplicantReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.applicants.index')
        : redirect()->route('applicant.register');
});

// ── Authentication (guest) ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Public Registration ────────────────────────────────────────────────
Route::get('/applicant/register', [ApplicantRegistrationController::class, 'index'])
    ->name('applicant.register');

Route::post('/applicant/register', [ApplicantRegistrationController::class, 'store'])
    ->name('applicant.register.store');

Route::get(
    '/verification/{applicant}',
    [VerificationController::class, 'show']
)
    ->middleware('signed')
    ->name('verification.show');

// ── Admin area (authenticated) ─────────────────────────────────────────
Route::middleware('auth')->prefix('admin')->group(function () {

    // Applicants
    Route::prefix('applicants')->name('admin.applicants.')->group(function () {
        Route::get('/', [ApplicantManagementController::class, 'index'])->name('index');
        Route::get('/statistics', [ApplicantManagementController::class, 'statistics'])->name('statistics');
        Route::get('/data', [ApplicantManagementController::class, 'data'])->name('data');
        Route::get('/{id}', [ApplicantManagementController::class, 'show'])->name('show')->whereNumber('id');
        Route::post('/{id}/verify', [ApplicantManagementController::class, 'verify'])->name('verify')->whereNumber('id');
        Route::post('/{id}/reject', [ApplicantManagementController::class, 'reject'])->name('reject')->whereNumber('id');
        Route::delete('/{id}', [ApplicantManagementController::class, 'destroy'])->name('destroy')->whereNumber('id');
        Route::get('/{id}/download-id', [ApplicantManagementController::class, 'downloadId'])->name('download-id')->whereNumber('id');
    });

    // Users
    Route::prefix('users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/statistics', [UserController::class, 'statistics'])->name('statistics');
        Route::get('/data', [UserController::class, 'data'])->name('data');
        Route::get('/{id}', [UserController::class, 'show'])->name('show')->whereNumber('id');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update')->whereNumber('id');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy')->whereNumber('id');
    });

    Route::prefix('email-templates')->name('admin.email-templates.')->group(function () {
        Route::get('/', [EmailTemplateController::class, 'index'])->name('index');
        Route::get('/data', [EmailTemplateController::class, 'data'])->name('data');
        Route::get('/{id}', [EmailTemplateController::class, 'show'])->name('show')->whereNumber('id');
        Route::put('/{id}', [EmailTemplateController::class, 'update'])->name('update')->whereNumber('id');
        Route::post('/{id}/toggle', [EmailTemplateController::class, 'toggle'])->name('toggle')->whereNumber('id');
        Route::post('/{id}/preview', [EmailTemplateController::class, 'preview'])->name('preview')->whereNumber('id');
        Route::post('/{id}/test', [EmailTemplateController::class, 'sendTest'])->name('test')->whereNumber('id');
    });

    Route::get('/reports/verified-by-school', [ApplicantReportController::class, 'verifiedBySchool'])
        ->name('reports.verified-by-school');
});
