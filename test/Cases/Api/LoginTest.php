<?php

namespace HyperfTest\Cases\Api;

use App\Model\User;
use Hyperf\Testing\TestCase;
use HyperfTest\TestUtils;
use Swoole\Http\Status;

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
                'token',
                'expires_at',
                'expires_in',
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
