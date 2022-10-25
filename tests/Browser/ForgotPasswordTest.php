<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ForgotPassword;
use Tests\DuskTestCase;

class ForgotPasswordTest extends DuskTestCase
{
    /**
     * @test
     */
    public function example()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ForgotPassword);
        });
    }
}
