<?php

namespace Test\Cases\Unit\User;

use App\Domain\User\Retailer;
use App\Domain\User\UserDomainInterface;
use App\Exception\User\Retailer\RetailerCantExecutePaymentException;
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


    public function testCanExecutePayment()
    {
        $this->user->setId(1);

        $this->expectException(RetailerCantExecutePaymentException::class);
        $this->user->canExecutePayment(2);
    }
}
