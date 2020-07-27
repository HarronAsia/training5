<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Report extends Model
{
    use Notifiable,SoftDeletes;

    protected $fillable = [
        'name','email','reason','detail','user_id'
    ];

    public function reportable()
    {
        return $this->morphTo();
    }
}
