<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Tag extends Model
{
    use SoftDeletes,Notifiable;

    protected $fillable = [
        'name','thread_id',
    ];

    public function threads()
    {
        return $this->belongsToMany('App\Models\Thread');
    }
}
