<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $timestamps = true;

    public $fillable = [
        'user_id', 'post_id', 'description'
    ];

    public function user(){
        return $this->belongsTo(Comment::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

}
