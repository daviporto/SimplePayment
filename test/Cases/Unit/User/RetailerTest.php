<?php

namespace Test\Cases\Unit\User;

use App\Domain\User\Retailer;
use App\Domain\User\UserDomainInterface;
use PHPUnit\Framework\TestCase;
use function Hyperf\Support\make;

class RetailerTest extends TestCase
{
    private UserDomainInterface $user;

    protected function setUp(): void
    {
        $this->user = make(Retailer::class, [make(UserTestRepository::class)]);
    }

    public function testGetDefaultBalanceOnUnloadedUser()
    {
        $this->assertSame($this->user->getInitialBalance(), Retailer::INITIAL_BALANCE);
    }
}
