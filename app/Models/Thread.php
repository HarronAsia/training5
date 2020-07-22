<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Thread extends Model
{
    use  SoftDeletes,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','detail', 'thumbnail','user_id','status','forum_id','tag_id'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function tags()
    {
        return $this->hasMany('App\Models\Tag');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

}
