<?php 

/**
* 
*/
class CreatePostsTest extends FeatureTestCase
{
	
	public function test_a_user_create_a_post()
	{	
		// Having
		$title = 'Esta es una pregunta';
		$content = 'Este es el contenido';

		$this->actingAs($user = $this->defaultUser());

		// When
		$this->visit(route('posts.create'))
			->type($title, 'title')
			->type($content, 'content')
			->press('Publicar');

		// Then
			$this->seeInDatabase('posts', [
				'title' => $title,
				'content' => $content,
				'pending' => true,
				'user_id' => $user->id,
			]);

		// Test a user is redirected to de posts detail after create a post
			$this->see($title);
	}

	public function test_creating_a_post_requires_authentication()
	{	
		// When
		$this->visit(route('posts.create'))
			->seePageIs(route('login'));
	}

	public function test_create_post_form_validation()
	{	
		// When
		$this->actingAs($this->defaultUser())
			->visit(route('posts.create'))
			->press('Publicar')
			->seePageIs(route('posts.create'))
			->seeErrors([
				'title' => 'el campo título es obligatorio',
				'content' => 'el campo contenido es obligatorio'
			]);
	}	
}