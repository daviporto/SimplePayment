<?php

namespace Test\Cases\Unit\User;

use App\Domain\User\Customer;
use App\Domain\User\UserDomainInterface;
use App\Exception\User\Customer\OnlyOwnUserCanExecutePaymentException;
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

    public function testCanExecutePaymentForAnotherUser()
    {
        $this->user->setId(1);
        $this->expectException(OnlyOwnUserCanExecutePaymentException::class);

        $this->user->canExecutePayment(2);
    }

    public function testCanExecutePaymentForOwnUser()
    {
        $this->user->setId(1);
        $this->assertSame($this->user, $this->user->canExecutePayment(1));
    }
}
