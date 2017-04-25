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
        $this->visit($post->url)
        	->seeInElement('h1', $post->title)
        	->see($post->content)
        	->see($user->name);
    }

    public function test_old_url_are_redirected ()
    {
        //Having
        $user = $this->defaultUser([
        ]);
        
        $post = factory(\App\Post::class)->make([
            'title' => 'Old title',
        ]);

        $user->posts()->save($post);
        
        $url = $post->url;

        $post->update(['title' => 'New title']);     

        $this->visit($url)
            ->seePageIs($post->url);   
    }

}
