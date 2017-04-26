<?php

class AcceptAnswerTest extends FeatureTestCase
{
    function test_the_post_author_can_accept_a_comment_as_the_posts_answer()
    {
    	$comment = factory(\App\Comment::class)->create([
    		'comment' => 'Esta es la respuesta del post'
    	]);

        $this->actingAs($comment->post->user);

        $this->visit($comment->post->url)
		->press('Aceptar respuesta');

       	$this->seeinDatabase('posts', [
       		'id' => $comment->post_id,
       		'pending' => false,
       		'answer_id' => $comment->id,
       	]);		

        $this->seePageIs($comment->post->url)
       		->seeInElement('.answer', $comment->comment);
    }

    function test_non_post_author_dont_see_the_accept_button()
    {
    	$comment = factory(\App\Comment::class)->create([
    		'comment' => 'Esta es la respuesta del post'
    	]);

        $this->actingAs(factory(\App\User::class)->create());

        $this->visit($comment->post->url)
		->dontSee('Aceptar respuesta');	
    }    

    function test_non_post_author_cannot_accept_a_comment_as_the_posts_answer()
    {
    	$comment = factory(\App\Comment::class)->create([
    		'comment' => 'Esta es la respuesta del post'
    	]);

        $this->actingAs(factory(\App\User::class)->create());

        $this->post(route('comments.accept', $comment));

       	$this->dontSeeinDatabase('posts', [
       		'id' => $comment->post_id,
       		'pending' => true,
       		'answer_id' => $comment->id,
       	]);		
    }

  function test_the_accept_button_is_hidden_when_the_comment_is_already_the_post_answer()
    {
    	$comment = factory(\App\Comment::class)->create([
    		'comment' => 'Esta es la respuesta del post'
    	]);

        $this->actingAs($comment->post->user);

        $comment->markAsAnswer();
        
        $this->visit($comment->post->url)
		->dontSee('Aceptar respuesta');	
    }    
}
