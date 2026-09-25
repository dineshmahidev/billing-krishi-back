<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ReportTypeController;
use App\Http\Controllers\Api\ParameterController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\LabSettingController;
use App\Http\Controllers\Api\CmsController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\CustomerController;

// Public
Route::post('/login', [AuthController::class, 'login']);
Route::get('/cms/landing', [CmsController::class, 'landing']);

// Public report download by report number (hero softcopy download)
Route::get('/reports/by-no/{reportNo}', [ReportController::class, 'byNo']);
Route::get('/reports/by-no/{reportNo}/pdf', [ReportController::class, 'pdfByNo']);
Route::get('/reports/by-no/{reportNo}/pdf/download', [ReportController::class, 'downloadPdfByNo']);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    Route::put('/user/password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Report Types (read for staff, write admin only enforced in controller)
    Route::get('/report-types', [ReportTypeController::class, 'index']);
    Route::get('/report-types/{id}', [ReportTypeController::class, 'show']);
    Route::post('/report-types', [ReportTypeController::class, 'store']);
    Route::put('/report-types/{id}', [ReportTypeController::class, 'update']);
    Route::delete('/report-types/{id}', [ReportTypeController::class, 'destroy']);

    // Parameters
    Route::get('/parameters', [ParameterController::class, 'index']);
    Route::get('/report-types/{id}/parameters', [ParameterController::class, 'byType']);
    Route::post('/parameters', [ParameterController::class, 'store']);
    Route::put('/parameters/{id}', [ParameterController::class, 'update']);
    Route::delete('/parameters/{id}', [ParameterController::class, 'destroy']);

    // Reports
    Route::get('/reports', [ReportController::class, 'index']);
    Route::post('/reports', [ReportController::class, 'store']);
    Route::get('/reports/{id}', [ReportController::class, 'show']);
    Route::put('/reports/{id}', [ReportController::class, 'update']);
    Route::delete('/reports/{id}', [ReportController::class, 'destroy']);

    // Staff (admin only - controller checks role)
    Route::get('/staff', [StaffController::class, 'index']);
    Route::post('/staff', [StaffController::class, 'store']);
    Route::get('/staff/{id}', [StaffController::class, 'show']);
    Route::put('/staff/{id}', [StaffController::class, 'update']);
    Route::patch('/staff/{id}/status', [StaffController::class, 'updateStatus']);
    Route::delete('/staff/{id}', [StaffController::class, 'destroy']);

    // Settings
    Route::get('/settings', [LabSettingController::class, 'index']);
    Route::put('/settings', [LabSettingController::class, 'update']);
    Route::post('/settings', [LabSettingController::class, 'update']);

    // CMS Landing (admin only for update)
    Route::put('/cms/landing', [CmsController::class, 'updateLanding']);
    Route::post('/cms/landing', [CmsController::class, 'updateLanding']);

    // Customers - searchable for autocomplete, all authenticated can read, admin write
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/search', [CustomerController::class, 'search']);
    Route::get('/customers/{id}', [CustomerController::class, 'show']);
    Route::get('/customers/{id}/summary', [CustomerController::class, 'summary']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::put('/customers/{id}', [CustomerController::class, 'update']);
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

    // Company groups
    Route::get('/customer-groups', [CustomerController::class, 'groups']);
    Route::post('/customer-groups', [CustomerController::class, 'storeGroup']);
    Route::put('/customer-groups/{id}', [CustomerController::class, 'updateGroup']);
    Route::delete('/customer-groups/{id}', [CustomerController::class, 'destroyGroup']);
    Route::post('/customer-groups/{id}/assign', [CustomerController::class, 'assignGroup']);

    // Invoices list - authenticated only (sidebar is admin-gated)
    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::put('/reports/{id}/invoice/gst', [InvoiceController::class, 'toggleGst']);
    Route::put('/reports/{id}/invoice/status', [InvoiceController::class, 'toggleStatus']);
    Route::put('/reports/{id}/invoice/items', [InvoiceController::class, 'updateItems']);
    Route::get('/group-summary', [InvoiceController::class, 'groupSummary']);
    Route::post('/group-summary/pdf', [InvoiceController::class, 'groupSummaryPdf']);
    Route::get('/bulk-settlement', [InvoiceController::class, 'bulkSettlement']);
    Route::post('/bulk-settlement/pdf', [InvoiceController::class, 'settlementPdf']);
});

// PDF/Word routes - public with optional auth via header OR ?token= (for window.open direct)
Route::get('/reports/{id}/pdf', [ReportController::class, 'pdf']);
Route::get('/reports/{id}/pdf/download', [ReportController::class, 'downloadPdf']);
Route::get('/reports/{id}/word', [ReportController::class, 'word']);
Route::get('/reports/{id}/word/download', [ReportController::class, 'downloadWord']);
Route::get('/reports/{id}/invoice', [InvoiceController::class, 'show']);
Route::get('/reports/{id}/invoice/pdf', [InvoiceController::class, 'pdf']);
Route::get('/reports/{id}/invoice/pdf/download', [InvoiceController::class, 'downloadPdf']);
Route::get('/reports/{id}/invoice/word', [InvoiceController::class, 'word']);
Route::get('/reports/{id}/invoice/word/download', [InvoiceController::class, 'downloadWord']);
