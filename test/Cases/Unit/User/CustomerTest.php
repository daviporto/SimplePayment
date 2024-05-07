<?php

namespace Test\Cases\Unit\User;

use App\Domain\User\Customer;
use App\Domain\User\UserDomainInterface;
use PHPUnit\Framework\TestCase;
use function Hyperf\Support\make;

class CustomerTest extends TestCase
{
    private UserDomainInterface $user;

    protected function setUp(): void
    {
        $this->user = make(Customer::class, [make(UserTestRepository::class)]);
    }

    public function testGetDefaultBalanceOnUnloadedUser()
    {
        $this->assertSame($this->user->getInitialBalance(), Customer::INITIAL_BALANCE);
    }
}
