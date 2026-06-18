<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\ConsignmentController;
use App\Http\Controllers\Api\AuditController;
use App\Http\Controllers\Api\CreditController;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Public Auth Routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        // Auth Routes
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        Route::get('/auth/me', [AuthController::class, 'me']);

        // Document Routes
        Route::apiResource('documents', DocumentController::class);
        Route::post('documents/{document}/clone', [DocumentController::class, 'clone']);

        // Consignment Routes
        Route::apiResource('consignments', ConsignmentController::class);

        // Audit Routes
        Route::get('audits', [AuditController::class, 'index']);
        Route::post('audits/run', [AuditController::class, 'run']);
        Route::get('audits/{auditId}', [AuditController::class, 'show']);

        // Credit Routes
        Route::get('credits/balance', [CreditController::class, 'balance']);
        Route::get('credits/history', [CreditController::class, 'history']);

        // Notification Routes
        Route::get('notifications', [NotificationController::class, 'index']);
        Route::get('notifications/unread', [NotificationController::class, 'unread']);
        Route::post('notifications/{notificationId}/read', [NotificationController::class, 'markAsRead']);
        Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead']);
        Route::get('notifications/preferences', [NotificationController::class, 'preferences']);
        Route::put('notifications/preferences', [NotificationController::class, 'updatePreferences']);
    });
});
