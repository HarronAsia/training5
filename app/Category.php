<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Forum;

class Category extends Model
{
    use SoftDeletes,Notifiable;

    protected $fillable = ['name','detail'];

    public function forums()
    {
        return $this->hasMany(Forum::class);
    }
}
