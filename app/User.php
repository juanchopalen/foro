<?php

namespace App;

use App\Comment;
use App\Post;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }    

    public function isSubscribedTo(Post $post)
    {
        return $this->subscriptions()->where('post_id', $post->id)->count() > 0;
    }

        public function subscribeTo(Post $post)
    {
        return $this->subscriptions()->attach($post);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Post::class, 'subscriptions');
    }    

    public function comment(Post $post, $message)
    {
        $comment = new Comment([
            'comment' => $message,
            'post_id' => $post->id,
        ]);

        $this->comments()->save($comment);
    }

    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }



}
