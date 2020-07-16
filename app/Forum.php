<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Category;
class Forum extends Model
{
    use SoftDeletes,Notifiable;
    
    protected $fillable = ['name'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
