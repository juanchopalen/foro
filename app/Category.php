<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Post;

class Category extends Model
{
	public function getRouteKeyName()
	{
	    return 'slug';
	}
	public function posts()
	{
		return $this->hasMany(Post::class);
	}
}
