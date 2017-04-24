<?php

class ShowPostTest extends FeatureTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_see_the_post_details()
    {
    	// Having
    	$user = $this->defaultUser([
    		'name' => 'Juan Palencia'
    	]);
        
        $post = factory(\App\Post::class)->make([
        	'title' => 'Este es el titulo del post',
        	'content' => 'este es el titulo del post',
        ]);

        $user->posts()->save($post);

        // When
        $this->visit(route('posts.show', $post))
        	->seeInElement('h1', $post->title)
        	->see($post->content)
        	->see($user->name);
    }
}
