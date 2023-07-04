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
            $page = $browser->visit(new Login);

            $page->assertFocused('#username input[type="text"]')
                ->type('@username', 'johndoe')
                ->type('@password', 'secret')
                ->pressAndWaitFor('@login');

            $page->assertSee(__('auth.failed'));
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
            $page = $browser->visit(new Login);

            $page->assertFocused('#username input[type="text"]')
                ->type('@username', $user->name)
                ->type('@password', 'secret')
                ->press('@login')
                ->waitForInertia();

            $page->assertSee(__('dashboard.routes.index'));
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
