<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    public $timestamps = true;


    public $fillable = [
        'name', 'password', 'email', 'description', 'link'
    ];

    //User has many posts
    public function posts(){
        return $this->hasMany(Post::class);
    }

    //User has many comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //User has many favourites
    public function favourites(){
        return $this->belongsToMany(Favourite::class, 'post_user');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
