<?php

namespace Test\Cases\Api;

use App\Domain\User\UserTypeEnum;
use App\Model\User;
use App\Model\Wallet;
use Faker\Factory;
use Hyperf\Testing\TestCase;
use Swoole\Http\Status;
use function Hyperf\Support\make;

class RegisterUserTest extends TestCase
{
    const ROUTE = 'api/user/register';

    public function testRegister()
    {
        $payload = $this->getPayload();

        $this->post(self::ROUTE, $payload)
            ->assertStatus(Status::NO_CONTENT);

        $this->assertTrue(User::where('email', $payload['email'])->exists());

        /** @var User $user */
        $user = User::where('email', $payload['email'])->first();

        $this->assertTrue(Wallet::where('owner_id', $user->id)->exists());
    }

    private function getPayload(): array
    {
        $faker = make(Factory::class)->create();

        return [
            'name' => $faker->name(),
            'email' => $faker->unique()->email(),
            'password' => '123456',
            'password_confirmation' => '123456',
            'cpf' => $faker->unique()->numerify('###########'),
            'type' => $faker->randomElement(UserTypeEnum::getTypes())
        ];
    }
}
