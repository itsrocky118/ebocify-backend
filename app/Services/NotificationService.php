<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationPreference;

class NotificationService
{
    /**
     * Send notification to user
     */
    public function send(User $user, string $type, string $title, string $message, ?array $data = null): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Get unread notifications for user
     */
    public function getUnreadNotifications(User $user)
    {
        return $user->notifications()
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get all notifications for user
     */
    public function getNotifications(User $user, int $limit = 50)
    {
        return $user->notifications()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification): Notification
    {
        $notification->markAsRead();
        return $notification;
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(User $user): void
    {
        $user->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Get notification preferences
     */
    public function getPreferences(User $user): ?NotificationPreference
    {
        return $user->notificationPreferences;
    }

    /**
     * Update notification preferences
     */
    public function updatePreferences(User $user, array $preferences): NotificationPreference
    {
        $prefs = $user->notificationPreferences ?? NotificationPreference::create(['user_id' => $user->id]);
        $prefs->update($preferences);

        return $prefs;
    }
}
