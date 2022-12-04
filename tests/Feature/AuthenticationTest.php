<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * @test
     */
    public function redirect_to_login_page_if_not_authenticated()
    {
        $this->get(RouteServiceProvider::HOME)->assertStatus(302);

        $this->getJson(RouteServiceProvider::HOME)->assertStatus(401);
    }

    /**
     * @test
     */
    public function should_not_be_able_to_authenticate_using_invalid_credential_through_form()
    {
        $response = $this->post('/login', [
            'username' => 'johndoe',
            'password' => 'secret',
        ]);

        $response->assertInvalid('username');
    }

    /**
     * @test
     */
    public function should_not_be_able_to_authenticate_using_invalid_credential_through_json()
    {
        $this->withoutMiddleware(ThrottleRequests::class);

        $response = $this->postJson('/login', [
            'username' => 'johndoe',
            'password' => 'secret',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'username' => __('auth.failed'),
        ]);
    }

    /**
     * @test
     */
    public function should_be_able_to_authenticate_using_existing_credential_through_form()
    {
        /** @var User */
        $user = User::factory()->create(['name' => 'creasi']);

        // Basic Form Request
        $this->post('/login', [
            'username' => $user->name,
            'password' => 'secret',
        ])->assertRedirect(RouteServiceProvider::HOME);

        $this->post('/logout')->assertRedirect('/');
    }

    /**
     * @test
     */
    public function should_be_able_to_authenticate_using_existing_credential_through_json()
    {
        $this->withoutMiddleware(ThrottleRequests::class);

        /** @var User */
        $user = User::factory()->create(['name' => 'creasi']);

        // JSON Form Request
        $response = $this->postJson('/login', [
            'username' => $user->name,
            'password' => 'secret',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'email'],
            'token',
        ]);

        $this->postJson('/logout')->assertStatus(204);
    }
}
