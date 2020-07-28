<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    use SoftDeletes,Notifiable;

    protected $fillable = ['detail','image'];
    protected $hidden = ['user_id', 'community_id',];


    public function community()
    {
        return $this->belongsTo('App\Models\Community');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
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

}
