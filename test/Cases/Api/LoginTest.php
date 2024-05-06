<?php

namespace Test\Cases\Api;

use App\Model\User;
use Hyperf\Testing\TestCase;
use Swoole\Http\Status;
use Test\TestUtils;

class LoginTest extends TestCase
{
    const ROUTE = 'api/user/login';

    public function testLogin()
    {
        $user = TestUtils::factory(User::class)->create();

        $payload = $this->getPayload($user);

        $this->post(self::ROUTE, $payload)
            ->assertStatus(Status::OK)
            ->assertJsonStructure([
                'data' => [
                    'token',
                    'expires_at',
                    'expires_in',
                ]
            ]);
    }

    private function getPayload(User $user): array
    {
        return [
            'email' => $user->email,
            'password' => '123456',
        ];
    }
}
