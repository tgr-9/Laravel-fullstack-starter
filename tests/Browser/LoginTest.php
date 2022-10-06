<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function testInvalidLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->type('@username', 'johndoe')
                ->type('@password', 'secret')
                ->press('@login')
                ->assertSee(__('auth.failed'));
        });
    }

    public function testUserLogin()
    {
        /** @var User */
        $user = User::factory()->create([
            'name' => 'creasi',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit(new Login)
                ->type('@username', $user->name)
                ->type('@password', 'secret')
                ->press('@login')
                ->assertRouteIs('home');
        });
    }
}
