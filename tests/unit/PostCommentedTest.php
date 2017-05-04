<?php

use App\Notifications\PostCommented;
use App\{User,Post, Comment};
use Illuminate\Notifications\Messages\MailMessage;

class PostCommentedTest extends TestCase
{


	/**
	*@test
	*/

	function it_builds_a_mail_message()
	    {
	    	$post = new Post([
	    		'title' => 'Titulo del post',
	    	]);

	    	$author = new User([
	    		'first_name' => 'Juan',
	    		'last_name' => 'Palencia'
	    	]);

	        $comment = new Comment();
	        $comment->post = $post;
	        $comment->user = $author;


	        $notification = new PostCommented($comment);

	        $subscriber = new User();

	        $message = $notification->toMail($subscriber);

	        $this->assertInstanceOf(MailMessage::class, $message);

	        $this->assertSame(
	        	'Nuevo comentario en: Titulo del post',
	        	$message->subject
	        );

	        $this->assertSame(
	        	'Juan Palencia escribió un comentario en: Titulo del post',
	        	$message->introLines[0]
	        );	        

	        $this->assertSame(
	        	$comment->post->url,
	        	$message->actionUrl
	        );
	    }
}
