<?php

use App\Notifications\PostCommented;
use App\User;
use App\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Notifications\Messages\MailMessage;

class PostCommentedTest extends TestCase
{

	use DatabaseTransactions;

	/**
	*@test
	*/

	function it_builds_a_mail_message()
	    {
	    	$post = factory(Post::class)->create([
	    		'title' => 'Titulo del post',
	    	]);

	    	$author = factory(User::class)->create([
	    		'name' => 'Juan Palencia'
	    	]);

	        $comment = factory(\App\Comment::class)->create([
	        	'post_id' => $post->id,
	        	'user_id' => $author->id,
	        ]);

	        $notification = new PostCommented($comment);

	        $subscriber = factory(User::class)->create();

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
