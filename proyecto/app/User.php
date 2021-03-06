<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use ChristianKuri\LaravelFavorite\Traits\Favoriteability;
use App\Post;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use Favoriteability;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','username','fotoPerfil', 'password',
    ];

    //Relación 1:N entre Posts y Users --> A la hora de publicar un post
    //Ya que un usuario podrá crear varios posts
    public function posts(){
        return $this->hasMany(Post::class);
    }

    //Relación 1:N entre Users y Comments
    //Un usuario podrá crear uno o varios comentarios.
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function totalPosts(){
        $sum = 0;
        foreach ($this->posts as $item) {
            $sum++;
        }
        return $sum;
    }

    public function totalComments(){
        $sum = 0;
        foreach ($this->comments as $item) {
            $sum++;
        }
        return $sum;
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



    
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
