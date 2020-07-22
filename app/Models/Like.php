<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Like extends Model
{
    use Notifiable;

    protected $fillable = ['user_id'];

    public function likeable()
    {
        return $this->morphTo();
    }
}
