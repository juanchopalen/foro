<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_a_user_can_logout()
    {
        $user = $this->defaultUser([
            'first_name' => 'Juan',
            'last_name' => 'Palencia',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->clickLink('Juan Palencia')
                    ->clickLink('Cerrar sesión')
                    ->assertGuest();
        });
    }
}
