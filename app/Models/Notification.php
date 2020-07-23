<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use SoftDeletes,Notifiable;

    public function users()
    {
        return $this->belongsTo('App\User');
    }

}
