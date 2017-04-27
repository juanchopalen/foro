<?php

use App\{User, Token};
use App\Mail\TokenMail;
use Illuminate\Support\Facades\Mail;

class RegistrationTest extends FeatureTestCase
{
	function test_a_user_can_create_an_account()
	{
		Mail::fake();

		$this->visitRoute('register')
			->type('juanchopalen@gmail.com', 'email')
			->type('klaustro', 'username')
			->type('Juan', 'first_name')
			->type('Palencia', 'last_name')
			->press('Registrate');

		$this->seeinDatabase('users',[
			'email' => 'juanchopalen@gmail.com',
			'username' => 'klaustro',
			'first_name' => 'Juan',
			'last_name' => 'Palencia',
		]);

		$user = User::first();

		$this->seeinDatabase('tokens', [
			'user_id' => $user->id
		]);

		$token = Token::where('user_id', $user->id)->first();

		$this->assertNotNull($token);

		Mail::assertSentTo($user, TokenMail::class, function ($mail) use ($token){
			return $mail->token->id == $token->id;
		});

		$this->seeRouteIs('register_confirmation')
			->see('Gracias por registrarte')
			->see('Enviamos a tu email un enlace para que inicies sesion ');
	}

	public function test_validate_user_registration()
	{
		$this->visitRoute('register')
			->press('Registrate')
			->seeErrors([
				'email' => 'el campo email es obligatorio',
				'username' => 'el campo username es obligatorio',
				'first_name' => 'el campo first_name es obligatorio',
				'last_name' => 'el campo last_name es obligatorio',
			]);   
	}    	
}
