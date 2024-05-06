<?php

declare(strict_types=1);


use App\Domain\User\UserTypeEnum;
use App\Model\User;
use Hyperf\Testing\ModelFactory;

/* @var ModelFactory $factory */
$factory->define(User::class, function (Faker\Generator $faker) {
     return [
         'email' => $faker->unique()->email(),
            'password' => password_hash('123456', PASSWORD_DEFAULT),
            'name' => $faker->name(),
            'cpf' => $faker->unique()->numerify('###########'),
            'type' => $faker->randomElement(UserTypeEnum::getTypes())
     ];
 });
