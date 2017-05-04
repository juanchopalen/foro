<?php

use Illuminate\Support\Facades\Mail;
use App\Token;

class AuthenticationTest extends FeatureTestCase
{

	    public function test_a_guest_user_can_request_a_token()
	    {
		//Having
		Mail::fake();

		$user = $this->defaultUser([
			'email' => 'klaustro@hotmail.com'
		]);

		//When
		$this->visitRoute('login')
			->type('klaustro@hotmail.com', 'email')
			->press('Solicitar Token');

		//Then: a token is created in the database
		$token = Token::where('user_id', $user->id)->first();

		$this->assertNotNull($token, 'A token was not created');

		//And sent to the user
		Mail::assertSentTo($user, \App\Mail\TokenMail::class, function($mail) use($token){
			return $mail->token->id === $token->id;

		});
	   	 $this->dontSeeIsAuthenticated();


		$this->see('Enviamos a tu email un enlace para que inicies sesion');
    }

	    public function test_a_guest_user_can_request_a_token_without_an_email()
	    {


		//When
		$this->visitRoute('login')
			->press('Solicitar Token');

		//Then: a token is created in the database
		$token = Token::first();

		$this->assertNull($token, 'A token was not created');

	    	$this->dontSeeIsAuthenticated();

		$this->seeErrors(['email' => 'El campo correo electrónico es obligatorio']);
    }    

	public function test_a_guest_user_can_request_a_token_with_a_non_exixtent_email()
	{


		$user = $this->defaultUser([
			'email' => 'juanchopalen@hotmail.com'
		]);

		//When
		$this->visitRoute('login')
		->type('klaustro@hotmail.com', 'email')
		->press('Solicitar Token');

		//Then: a token is created in the database
		$token = Token::first();

		$this->assertNull($token, 'A token was not created');

		$this->dontSeeIsAuthenticated();


		$this->seeErrors(['email' => 'Correo electrónico es inválido']);
	}      
}
