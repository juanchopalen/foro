<?php


class ExampleTest extends FeatureTestCase
{

    function test_basic_example()
    {

        $name = 'Juan Palencia';
        $email = 'juanchopalen@gmail.com';
        
        $user=factory(\App\User::class)->create([
            'name' => $name,
            'email' => $email,
        ]);

        $this->actingAs($user, 'api')
            ->visit('api/user')
            ->see($name)
            ->see($email);
    }
}
