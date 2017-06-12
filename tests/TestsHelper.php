<?php 
namespace Tests;

use App\{User, Post};

trait TestsHelper
{
    /**
     * @var \App\User
     */
    protected $defaultUser;


    public function defaultUser(array $attributes = [])
    {
        if ($this->defaultUser) {
            return $this->defaultUser;
        }

        return $this->defaultUser = factory(User::class)->create($attributes);
    }

    protected function createPost(array $attributes = [])
    {
        return factory(\App\Post::class)->create($attributes);
    }	


    protected function anyone(array $attributes = [])
    {
        return factory(User::class)->create($attributes);
    }
    
}