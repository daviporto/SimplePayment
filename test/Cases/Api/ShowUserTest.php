<?php

namespace Test\Cases\Api;

use App\Model\User;
use Hyperf\Testing\TestCase;
use Swoole\Http\Status;
use Test\TestUtils;

class ShowUserTest extends TestCase
{
    const ROUTE = 'api/user';

    public function testLogin()
    {
        $usersId = TestUtils::factory(User::class)
            ->times(5)
            ->create()
            ->pluck('id');


        $response = $this->get(
            self::ROUTE,
            headers: ['Authorization' => TestUtils::getToken($usersId->first())]
        )
            ->assertStatus(Status::OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'type',
                    ]
                ]
            ]);

        $ids = $response->json('data.*.id');
        $this->assertEmpty($usersId->diff($ids));
    }
}
