<?php
namespace HyperfTest;

use Faker\Factory as FakerFactory;
use Hyperf\Database\Model\Factory;
use Hyperf\Database\Model\Factory as HyperfFactory;
use function Hyperf\Support\make;

class FactoryWithFaker
{
    public function __invoke(): HyperfFactory
    {
        return HyperfFactory::construct(FakerFactory::create(), __DIR__ . '/Factories');
    }
}

function factory(string $class)
{
    return make(Factory::class)->of($class);
}
