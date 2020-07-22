<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Community extends Model
{
    use SoftDeletes,Notifiable;

    protected $fillable = ['title','banner'];

    public function posts()
    {
        $this->hasMany('App\Models\Post');
    }
}
