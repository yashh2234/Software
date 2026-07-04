<?php

use App\Http\Controllers\Api\AuditLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\BillingController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DueReportsController;
use App\Http\Controllers\Api\FinalReportsController;
use App\Http\Controllers\Api\UlrLinkController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\WorkflowTemplateController;
use App\Http\Controllers\Api\WorkflowStageController;
use App\Http\Controllers\Api\WorkflowTransitionController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\DocumentCategoryController;
use App\Http\Controllers\Api\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
    Route::get('/sessions', [AuthController::class, 'sessions']);
    Route::delete('/sessions/{session}', [AuthController::class, 'revokeSession']);
    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);
    Route::get('/dashboard/trends', [DashboardController::class, 'trends']);
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::get('/roles/{role}', [RoleController::class, 'show']);
    Route::put('/roles/{role}', [RoleController::class, 'update']);
    Route::delete('/roles/{role}', [RoleController::class, 'destroy']);
    Route::apiResource('users', UserController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::get('/registrations', [RegistrationController::class, 'index']);
    Route::post('/registrations', [RegistrationController::class, 'store']);
    Route::put('/registrations/{registrationId}', [RegistrationController::class, 'update']);
    Route::get('/registrations/generate-uid', [RegistrationController::class, 'generateUid']);
    Route::post('/registrations/upload-scan', [RegistrationController::class, 'uploadScan']);
    Route::get('/registrations/search-customers', [RegistrationController::class, 'searchCustomers']);
    Route::get('registrations/{registration}/history', [RegistrationController::class, 'history']);
        Route::get('/billing', [BillingController::class, 'index']);
        Route::get('/billing/due', [BillingController::class, 'due']);
        Route::get('/billing/sms-log', [BillingController::class, 'smsLog']);
        Route::get('/billing/{id}', [BillingController::class, 'show']);
        Route::post('/billing', [BillingController::class, 'store']);
        Route::post('/billing/send-sms', [BillingController::class, 'sendSms']);
        Route::post('/billing/send-all-sms', [BillingController::class, 'sendAllSms']);
        Route::put('/billing/{id}', [BillingController::class, 'update']);
        Route::put('/billing/registration/{id}', [BillingController::class, 'updateRegistration']);
        Route::delete('/billing/{id}', [BillingController::class, 'destroy']);
    Route::get('/reports/types', [ReportController::class, 'types']);
    Route::get('/reports/{type}', [ReportController::class, 'index']);
    Route::get('/reports/{type}/{reportId}', [ReportController::class, 'show']);
    Route::post('/reports/cube', [ReportController::class, 'createCube']);
    Route::post('/reports/{reportId}/approve', [ReportController::class, 'approve']);
    Route::post('/reports/{reportId}/cancel', [ReportController::class, 'cancel']);
    Route::post('/reports/{reportId}/assign', [ReportController::class, 'assign']);
    Route::post('/reports/{reportId}/start-testing', [ReportController::class, 'startTesting']);
    Route::post('/reports/{reportId}/generate-report', [ReportController::class, 'generateReport']);
    Route::get('/reports/{reportId}/timeline', [ReportController::class, 'timeline']);
    Route::post('reports/{reportId}/reapprove', [ReportController::class, 'reapprove']);
    Route::post('reports/{type}/{reportId}/observations', [ReportController::class, 'saveObservations']);
    Route::get('/lab/assigned', [ReportController::class, 'myAssigned']);

    Route::get('/settings/company', [SettingsController::class, 'company']);
    Route::put('/settings/company', [SettingsController::class, 'updateCompany']);

    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::post('/expenses', [ExpenseController::class, 'store']);

    Route::apiResource('purchase-orders', PurchaseOrderController::class);
    Route::get('/purchase-orders/{id}/print', [PurchaseOrderController::class, 'printDiv']);

    Route::get('/audit-logs', [AuditLogController::class, 'index']);
    Route::get('/search', [SearchController::class, 'search']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);

    Route::apiResource('invoices', InvoiceController::class);
    Route::get('/invoices/{id}/print', [InvoiceController::class, 'printDiv']);

    Route::apiResource('invoices', \App\Http\Controllers\Api\InvoiceController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::get('invoices/{id}/print', [\App\Http\Controllers\Api\InvoiceController::class, 'printInvoice']);

    Route::post('/track/ping', [TrackingController::class, 'ping']);
    Route::post('/track/page', [TrackingController::class, 'page']);
    Route::get('/track/summary', [TrackingController::class, 'summary']);
    Route::get('/track/user/{userId?}', [TrackingController::class, 'userActivity']);

    Route::get('reports/{type}/{id}/print', [ReportController::class, 'printReport']);
    Route::get('due-reports', [DueReportsController::class, 'index']);
    Route::get('final-reports', [FinalReportsController::class, 'index']);
    Route::delete('final-reports/{id}', [FinalReportsController::class, 'destroy']);

    Route::apiResource('ulr-links', UlrLinkController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::post('ulr-links/client-details', [UlrLinkController::class, 'getClientDetails']);

    Route::apiResource('stores', StoreController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('reports/{type}/export', [ReportController::class, 'export']);

    Route::get('dashboard/cash-summary', [DashboardController::class, 'cashSummary']);

    Route::prefix('workflow')->group(function (): void {
        Route::post('seed', [WorkflowTemplateController::class, 'seed']);
        Route::apiResource('templates', WorkflowTemplateController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

        Route::get('templates/{workflowTemplate}/stages', [WorkflowStageController::class, 'index']);
        Route::post('templates/{workflowTemplate}/stages', [WorkflowStageController::class, 'store']);
        Route::get('stages/{workflowStage}', [WorkflowStageController::class, 'show']);
        Route::put('stages/{workflowStage}', [WorkflowStageController::class, 'update']);
        Route::delete('stages/{workflowStage}', [WorkflowStageController::class, 'destroy']);

        Route::get('templates/{workflowTemplate}/transitions', [WorkflowTransitionController::class, 'index']);
        Route::post('templates/{workflowTemplate}/transitions', [WorkflowTransitionController::class, 'store']);
        Route::get('transitions/{workflowTransition}', [WorkflowTransitionController::class, 'show']);
        Route::put('transitions/{workflowTransition}', [WorkflowTransitionController::class, 'update']);
        Route::delete('transitions/{workflowTransition}', [WorkflowTransitionController::class, 'destroy']);
    });

    Route::prefix('jobs')->group(function (): void {
        Route::get('/', [JobController::class, 'index']);
        Route::post('/', [JobController::class, 'store']);
        Route::get('sla-summary', [JobController::class, 'slaSummary']);
        Route::post('link-registration', [JobController::class, 'linkRegistration']);
        Route::get('{job}', [JobController::class, 'show']);
        Route::put('{job}', [JobController::class, 'update']);
        Route::delete('{job}', [JobController::class, 'destroy']);
        Route::post('{job}/transition', [JobController::class, 'transition']);
        Route::get('{job}/allowed-transitions', [JobController::class, 'allowedTransitions']);
        Route::post('{job}/return-to-stage', [JobController::class, 'returnToStage']);
        Route::post('{job}/assign', [JobController::class, 'assign']);
        Route::post('{job}/cancel', [JobController::class, 'cancel']);
        Route::get('{job}/timeline', [JobController::class, 'timeline']);
    });

    Route::prefix('permissions')->group(function (): void {
        Route::get('/', [PermissionController::class, 'index']);
        Route::post('seed', [PermissionController::class, 'seed']);
        Route::get('roles/{role}', [PermissionController::class, 'rolePermissions']);
        Route::post('roles/{role}/sync', [PermissionController::class, 'syncRolePermissions']);
        Route::post('users/assign', [PermissionController::class, 'assignToUser']);
        Route::get('users/{userId}', [PermissionController::class, 'userPermissions']);
    });

    Route::prefix('documents')->group(function (): void {
        Route::get('/', [DocumentController::class, 'index']);
        Route::post('/', [DocumentController::class, 'store']);
        Route::get('search', [DocumentController::class, 'search']);
        Route::get('categories/tree', [DocumentCategoryController::class, 'tree']);
        Route::get('categories', [DocumentCategoryController::class, 'index']);
        Route::post('categories', [DocumentCategoryController::class, 'store']);
        Route::get('categories/{documentCategory}', [DocumentCategoryController::class, 'show']);
        Route::put('categories/{documentCategory}', [DocumentCategoryController::class, 'update']);
        Route::delete('categories/{documentCategory}', [DocumentCategoryController::class, 'destroy']);
        Route::get('{document}', [DocumentController::class, 'show']);
        Route::put('{document}', [DocumentController::class, 'update']);
        Route::delete('{document}', [DocumentController::class, 'destroy']);
        Route::post('{document}/versions', [DocumentController::class, 'uploadVersion']);
        Route::get('{document}/download/{versionId?}', [DocumentController::class, 'download']);
        Route::get('{document}/preview', [DocumentController::class, 'preview']);
        Route::get('{document}/downloads', [DocumentController::class, 'downloadHistory']);
    });
});