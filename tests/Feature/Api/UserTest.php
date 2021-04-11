<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $accessToken = null;
    private $bearerToken = null;

    /**
     * Set up
     */
    protected function setUp(): Void
    {
        parent::setUp();

        $credentials = [
            'email' => 'user@test.jp',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ];
        $response = $this->postJson('/login', $credentials);
        $response->assertOk();
        $response->assertJsonStructure([
            'status',
            'message',
            'response' => [
                'token'
            ]
        ]);

        $this->accessToken = $response->json()['response']['token'];
        $this->bearerToken = 'Bearer ' . $this->accessToken;
    }

    /**
     * A basic web access test
     *
     * @return void
     */
    public function testWelcome()
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    /**
     * Login test
     *
     * @return void
     */
    public function testApiLoginNoCredentials()
    {
        $credentials = [];
        $response = $this->postJson('/login', $credentials);
        $response->assertUnauthorized();
    }

    public function testApiLoginEmptyCredentials()
    {
        $credentials = [
            'email' => '',
            'password' => ''
        ];
        $response = $this->postJson('/login', $credentials);
        $response->assertUnauthorized();
    }

    /**
     * Logout test
     *
     * @return void
     */
    public function testApiLogoutNoCredentials()
    {
        $response = $this->getJson('/logout');
        $response->assertUnauthorized();
    }

    public function testApiLogout()
    {
        $response = $this->withHeaders(['Authorization' => $this->bearerToken])->getJson('/logout');
        $response->assertOk();
    }

    /**
     * Get user list
     *
     * @return void
     */
    public function testSpaGetUserListWithoutAuth()
    {
        $response = $this->getJson('/user');
        $response->assertUnauthorized();
    }

    public function testSpaGetUserList()
    {
        $response = $this->withHeaders(['Authorization' => $this->bearerToken])->getJson('/user');
        $response->assertOk();
    }
}
