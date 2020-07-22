<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    use Notifiable,SoftDeletes;

    protected $fillable = ['comment_image','comment_detail','user_id'];
    
    public function commentable()
    {
        return $this->morphTo();
    }
}
