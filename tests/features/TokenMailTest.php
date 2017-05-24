<?php

use App\Mail\TokenMail;
use App\{Token, User};
use \Symfony\Component\DomCrawler\Crawler;

class TokenMailTest extends FeatureTestCase
{
    /**
     * A basic test example.
     *
     * @test 
     */
    public function it_sends_a_email_with_the_token()
    {

    	$user = new User([
    		'first_name' => 'Juan',
    		'last_name' => 'Palencia',
    		'email' => 'klaustro@hotmail.com'
    	]);
    	$token = new Token([
    		'token' => 'this-is-a-token',
    		'user' => $user
    	]);

    	$this->open(new  TokenMail($token))
    		->seeLink($token->url, $token->url);

    }

    protected function open(\Illuminate\Mail\Mailable $mailable)
    {

        $transport = Mail::getSwiftMailer()->getTransport();

        $transport->flush();

        Mail::send($mailable);

        $message = $transport->messages()->first();

        $this->crawler = new Crawler($message->getBody());    

        return $this;	
    }
}
