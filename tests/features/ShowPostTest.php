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
        
        $post =$this->createPost([
            'title' => 'Este es el titulo del post',
            'content' => 'este es el titulo del post',
            'user_id' => $user->id,
        ]);

        // When
        $this->visit($post->url)
        	->seeInElement('h1', $post->title)
        	->see($post->content)
        	->see('Juan Palencia');
    }

    public function test_old_url_are_redirected ()
    {
        
        $post = $this->createPost([
            'title' => 'Old title'
        ]);
        $url = $post->url;

        $post->update(['title' => 'New title']);     

        $this->visit($url)
            ->seePageIs($post->url);   
    }

}
