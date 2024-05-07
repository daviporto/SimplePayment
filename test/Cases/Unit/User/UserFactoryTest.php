<?php

namespace Test\Cases\Unit\User;

use App\Domain\User\Customer;
use App\Domain\User\Retailer;
use App\Domain\User\UserFactory;
use App\Domain\User\UserTypeEnum;
use PHPUnit\Framework\TestCase;
use function Hyperf\Support\make;

class UserFactoryTest extends TestCase
{
    public function testCreateRetailer()
    {
        $user = UserFactory::createUser(UserTypeEnum::Retailer->value, make(UserTestRepository::class));

        $this->assertInstanceOf(Retailer::class, $user);
    }

    public function testCreateCustomer()
    {
        $user = UserFactory::createUser(UserTypeEnum::Customer->value, make(UserTestRepository::class));

        $this->assertInstanceOf(Customer::class, $user);
    }
}
