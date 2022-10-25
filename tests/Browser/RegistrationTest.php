<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Register;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{
    /**
     * @test
     */
    public function example()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register);
        });
    }
}
