<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use Notifiable;

    protected $fillable = ['data', 'user_id'];

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

}
