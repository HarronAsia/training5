<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Forum extends Model
{
    use SoftDeletes,Notifiable;
    
    protected $fillable = ['name'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function threads()
    {
        return $this->hasMany('App\Models\Thread');
    }
}
