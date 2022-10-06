<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ForgotPassword;
use Tests\DuskTestCase;

class ForgotPasswordTest extends DuskTestCase
{
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ForgotPassword);
        });
    }
}
