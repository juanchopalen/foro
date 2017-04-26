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
}
