<?php

use App\User;
use App\Notifications\PostCommented;

use Illuminate\Support\Facades\Notification;

class NotifyUsersTest extends FeatureTestCase
{
    public function test_the_suscribers_receive_a_notification_when_post_is_commented()
    {

    	Notification::fake();

    	$post = $this->createPost();

    	$subscriber = factory(User::class)->create();

    	$subscriber->subscribeTo($post);

    	$writer = factory(User::class)->create();

    	$comment = $writer->comment($post, 'Un comentario cualquiera');

    	Notification::assertSentTo(
    		$subscriber, PostCommented::class, function ($notification) use($comment){
    			return $notification->comment->id == $comment->id;
    		}
    	);

    	Notification::assertNotSentTo($writer, PostCommented::class);
    }
}
