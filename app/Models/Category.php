<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class Category extends Model
{
    use SoftDeletes,Notifiable;

    protected $fillable = ['name','detail'];

    public function forums()
    {
        return $this->hasMany('App\Models\Forum');
    }
}
