<?php

namespace Test\Cases\Unit\Repository;

use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\UserTypeEnum;
use Faker\Factory;
use function Hyperf\Support\make;

class UserTestRepository implements UserRepositoryInterface
{

    public function save(array $data): void
    {

    }

    public function findByEmail(string $email): array
    {
        $faker = make(Factory::class)->create();

        return [
            'id' => $faker->unique()->randomNumber(),
            'email' => $email,
            'name' => $faker->name(),
            'password' => $faker->password(),
            'cpf' => 1 . $faker->unique()->numerify('##########'),
            'type' => $faker->randomElement(UserTypeEnum::getTypes())
        ];
    }

    public function emailExists(string $email): bool
    {
        return str_contains($email, 'exists');
    }

    public function cpfExists(string $cpf): bool
    {
        return ((int)substr($cpf, 0, 1)) % 2 == 0;
    }
}
