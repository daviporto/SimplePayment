<?php

namespace HyperfTest;

use Hyperf\Context\ApplicationContext;
use Hyperf\Database\Model\Factory;

class TestUtils
{
    public static function factory(string $class)
    {
        return ApplicationContext::getContainer()->get(Factory::class)->of($class);
    }
}
