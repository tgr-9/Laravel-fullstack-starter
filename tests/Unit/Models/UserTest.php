<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_hashing_password()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => $password = 'password',
        ]);

        $user->makeVisible('password');

        $this->assertTrue(Hash::check($password, $user->password));
    }

    public function test_add_user_profile()
    {
        $this->markTestSkipped();

        /** @var User $user */
        $user = User::factory()->create();
        /** @var Account $profile */
        $profile = Account::factory()->person()->make();

        $user->accounts()->save($profile);

        $this->assertCount(1, $user->profiles);
    }
}
