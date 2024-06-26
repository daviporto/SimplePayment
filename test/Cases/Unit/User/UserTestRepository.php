<?php

namespace Test\Cases\Unit\User;

use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\UserTypeEnum;
use Faker\Factory;
use function Hyperf\Support\make;

class UserTestRepository implements UserRepositoryInterface
{

    public function save(array $data): void
    {
        // test method
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

    public function idExists(int $id): bool
    {
        return $id % 2 == 0;
    }

    public  function findById(int $id): array
    {
        $faker = make(Factory::class)->create();

        return [
            'id' => $id,
            'email' => $faker->unique()->email(),
            'name' => $faker->name(),
            'password' => $faker->password(),
            'cpf' => 1 . $faker->unique()->numerify('##########'),
            'type' => $faker->randomElement(UserTypeEnum::getTypes())
        ];
    }

    public function findAll(): array
    {
        $user = $this->findById(1);

        return array_fill(0, 5, $user);
    }
}
