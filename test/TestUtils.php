<?php

namespace Test;

use App\Service\TokenService;
use Hyperf\Context\ApplicationContext;
use Hyperf\Database\Model\Factory;
use function Hyperf\Support\make;

class TestUtils
{
    public static function factory(string $class)
    {
        return ApplicationContext::getContainer()->get(Factory::class)->of($class);
    }

    public static function getToken(int $id): string
    {
        return 'Bearer ' . make(TokenService::class)->generateToken($id);;
    }
}
