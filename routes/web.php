<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Farmer\OnboardingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FarmerVerificationController;
use App\Http\Controllers\Admin\FarmUpdateController;
use App\Http\Controllers\Admin\FarmVerificationController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\InvestorController;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Investor public and portfolio routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/investor/farms/{farm}', [InvestorController::class, 'showFarm'])->name('investor.farms.show');
    Route::post('/investor/farms/{farm}/invest', [InvestorController::class, 'invest'])->name('investor.farms.invest');
    Route::get('/investor/portfolio/{farm}', [InvestorController::class, 'trackInvestment'])->name('investor.portfolio.track');
    Route::get('/export-report', [DashboardController::class, 'exportReport'])->name('reports.export');
});

// Farmer routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/farmer/onboarding', [OnboardingController::class, 'index'])->name('farmer.onboarding');
    Route::post('/farmer/onboarding', [OnboardingController::class, 'submit'])->name('farmer.onboarding.submit');
});

// Authentication routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');

// Admin panel routes (protected by auth middleware)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/farmers', [FarmerVerificationController::class, 'index'])->name('admin.farmers.index');
    Route::get('/farmers/{farmer}', [FarmerVerificationController::class, 'show'])->name('admin.farmers.show');
    Route::get('/farmers/{farmer}/edit', [FarmerVerificationController::class, 'edit'])->name('admin.farmers.edit');
    Route::post('/farmers/{farmer}/approve', [FarmerVerificationController::class, 'approve'])->name('admin.farmers.approve');
    Route::post('/farmers/{farmer}/reject', [FarmerVerificationController::class, 'reject'])->name('admin.farmers.reject');
    Route::delete('/farmers/{farmer}', [FarmerVerificationController::class, 'destroy'])->name('admin.farmers.destroy');
    Route::put('/farmers/{farmer}', [FarmerVerificationController::class, 'update'])->name('admin.farmers.update');
    Route::get('/farmers/{farmer}/download/{path}', [FarmerVerificationController::class, 'download'])->name('admin.farmers.download');
    Route::get('/farmers/{farmer}/pdf', [FarmerVerificationController::class, 'exportPdf'])->name('admin.farmers.pdf');

    Route::get('/farms', [FarmVerificationController::class, 'index'])->name('admin.farms.index');
    Route::get('/farms/create', [FarmVerificationController::class, 'create'])->name('admin.farms.create');
    Route::post('/farms', [FarmVerificationController::class, 'store'])->name('admin.farms.store');
    Route::get('/farms/{farm}/edit', [FarmVerificationController::class, 'edit'])->name('admin.farms.edit');
    Route::put('/farms/{farm}', [FarmVerificationController::class, 'update'])->name('admin.farms.update');
    Route::delete('/farms/{farm}', [FarmVerificationController::class, 'destroy'])->name('admin.farms.destroy');
    Route::post('/farms/{farm}/updates', [FarmUpdateController::class, 'store'])->name('admin.farms.updates.store');
    Route::post('/sales', [SaleController::class, 'store'])->name('admin.sales.store');
    Route::put('/sales/{sale}', [SaleController::class, 'update'])->name('admin.sales.update');
    Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('admin.sales.destroy');
    Route::get('/sales/{sale}/verify', [SaleController::class, 'verify'])->name('admin.sales.verify');
    Route::post('/harvests', [\App\Http\Controllers\Admin\HarvestController::class, 'store'])->name('admin.harvests.store');
    Route::put('/harvests/{harvest}', [\App\Http\Controllers\Admin\HarvestController::class, 'update'])->name('admin.harvests.update');
    Route::delete('/harvests/{harvest}', [\App\Http\Controllers\Admin\HarvestController::class, 'destroy'])->name('admin.harvests.destroy');

    Route::get('/farms/{farm}', [FarmVerificationController::class, 'show'])->name('admin.farms.show');
    Route::get('/farms/{farm}/edit', [FarmVerificationController::class, 'edit'])->name('admin.farms.edit');

    Route::post('/farms/{farm}/approve', [FarmVerificationController::class, 'approve'])->name('admin.farms.approve');
    Route::post('/farms/{farm}/reject', [FarmVerificationController::class, 'reject'])->name('admin.farms.reject');
    Route::post('/farms/{farm}/stop-collecting', [FarmVerificationController::class, 'stopCollecting'])->name('admin.farms.stop_collecting');
    Route::post('/farms/{farm}/settle', [FarmVerificationController::class, 'settle'])->name('admin.farms.settle');
    Route::post('/farms/{farm}/disburse', [FarmVerificationController::class, 'disburse'])->name('admin.farms.disburse');
    Route::post('/farms/{farm}/approve-disburse', [FarmVerificationController::class, 'approveDisbursement'])->name('admin.farms.approve_disburse');
    Route::post('/farms/{farm}/reject-disburse', [FarmVerificationController::class, 'rejectDisbursement'])->name('admin.farms.reject_disburse');
    Route::post('/investments', [DashboardController::class, 'storeInvestment'])->name('admin.investments.store');
    Route::post('/investments/{investment}/approve', [DashboardController::class, 'approveInvestment'])->name('admin.investments.approve');
    Route::post('/investments/{investment}/reject', [DashboardController::class, 'rejectInvestment'])->name('admin.investments.reject');
    Route::put('/investments/{investment}', [DashboardController::class, 'updateInvestment'])->name('admin.investments.update');
    Route::delete('/investments/{investment}', [DashboardController::class, 'destroyInvestment'])->name('admin.investments.destroy');

    Route::post('/investor-users/{user}/approve', [DashboardController::class, 'approveInvestorUser'])->name('admin.investor_users.approve');
    Route::post('/investor-users/{user}/reject', [DashboardController::class, 'rejectInvestorUser'])->name('admin.investor_users.reject');

    Route::get('/analytics', function () {
        return redirect()->route('admin.dashboard', ['tab' => 'analytics']);
    })->name('admin.analytics');

    Route::get('/logs', function () {
        return redirect()->route('admin.dashboard', ['tab' => 'logs']);
    })->name('admin.logs.index');
});

