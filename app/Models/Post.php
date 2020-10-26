<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = true;


    public $fillable = [
        'name', 'tags', 'image','user_id' , 'description'
    ];


    //Post has one user
    public function user(){
        return $this->belongsTo(Post::class);
    }

    //Post has many comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //Post has many users that favourite the post
    public function users(){
        return $this->belongsToMany(User::class, 'post_user');
    }

    //Post has many tags
    public function tags(){
        return $this->belongsToMany(Tag::class, 'post_tag');
    }


}
