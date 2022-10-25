<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class AuthenticationTest extends DuskTestCase
{
    /**
     * @test
     */
    public function should_not_be_able_to_authenticate_using_invalid_credential()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->type('@username', 'johndoe')
                ->type('@password', 'secret')
                ->press('@login')
                ->assertSee(__('auth.failed'));
        });
    }

    /**
     * @test
     */
    public function should_be_able_to_authenticate_using_existing_credential()
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

    /**
     * @test
     */
    public function should_be_able_to_logout()
    {
        $this->markTestIncomplete('not yet implemented');
    }
}
