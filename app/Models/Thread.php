<?php

namespace App\Models;

use App\ThreadUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Thread extends Model
{
    use  SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'detail', 'thumbnail', 'user_id', 'status', 'forum_id', 'tag_id'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'followers', 'following_id', 'follower_id')->withTimestamps();
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

    public function like()
    {
        return $this->morphOne('App\Models\Like', 'likeable');
    }

    public function reports()
    {
        return $this->morphMany('App\Models\Report', 'reportable');
    }
}
