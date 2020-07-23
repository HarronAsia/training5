<?php

namespace App\Repositories\Notification;

interface NotificationRepositoryInterface
{
    public function showall();

    public function showUnread();
}
