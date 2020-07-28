<?php

namespace App\Repositories\Notification;

interface NotificationRepositoryInterface
{
    public function showall();
    public function showallUnread();

    public function showUnread();

    public function readAt($id);
    public function readAll();

    public function deleteNotification($id);
}
