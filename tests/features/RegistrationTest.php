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

		$this->see('Enviamos a tu email un enlace para que inicies sesion');
	}
	
}
