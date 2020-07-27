<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use Notifiable;

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

}
