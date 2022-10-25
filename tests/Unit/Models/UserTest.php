<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function hashing_password()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => $password = 'password',
        ]);

        $user->makeVisible('password');

        $this->assertTrue(Hash::check($password, $user->password));
    }
}
