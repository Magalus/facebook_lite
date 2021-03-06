<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Like;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'message',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comments()
    {
         return $this->hasMany('App\Models\Comment');
    }

    public function likes() {
		return $this->morphMany('App\Models\Like', 'likeable');
	}
}
