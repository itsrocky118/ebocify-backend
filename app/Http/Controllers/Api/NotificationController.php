<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get all notifications
     */
    public function index(Request $request)
    {
        $notifications = $this->notificationService->getNotifications($request->user());

        return response()->json($notifications);
    }

    /**
     * Get unread notifications
     */
    public function unread(Request $request)
    {
        $notifications = $this->notificationService->getUnreadNotifications($request->user());

        return response()->json($notifications);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $notificationId)
    {
        $notification = $request->user()->notifications()->findOrFail($notificationId);
        $this->notificationService->markAsRead($notification);

        return response()->json(['message' => 'Notification marked as read']);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $this->notificationService->markAllAsRead($request->user());

        return response()->json(['message' => 'All notifications marked as read']);
    }

    /**
     * Get notification preferences
     */
    public function preferences(Request $request)
    {
        $preferences = $this->notificationService->getPreferences($request->user());

        return response()->json($preferences);
    }

    /**
     * Update notification preferences
     */
    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'email_document_created' => 'boolean',
            'email_credit_low' => 'boolean',
            'email_certificate_expiring' => 'boolean',
            'email_monthly_summary' => 'boolean',
            'email_product_updates' => 'boolean',
            'push_document_ready' => 'boolean',
            'push_audit_completed' => 'boolean',
        ]);

        $preferences = $this->notificationService->updatePreferences($request->user(), $validated);

        return response()->json([
            'message' => 'Preferences updated successfully',
            'preferences' => $preferences,
        ]);
    }
}
