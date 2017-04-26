<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\{Comment, User};
use App\Policies\CommentPolicy;

class CommentPolicyTest extends TestCase
{

	use DatabaseTransactions;

	public function test_the_posts_author_can_select__a_comment_an_answer()
	{
		$comment = factory(Comment::class)->create();

		$policy = new CommentPolicy;

		$this->assertTrue(
			$policy->accept($comment->post->user, $comment)
		);
	}

	public function test_the_posts_author_cannot_select__a_comment_an_answer()
	{
		$comment = factory(Comment::class)->create();

		$policy = new CommentPolicy;

		$this->assertFalse(
			$policy->accept(factory(User::class)->create(), $comment)
		);
	}

}
