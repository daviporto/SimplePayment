<?php

namespace App\Domain\User;

enum UserTypeEnum: string
{
    case Customer = 'customer';
    case Retailer = 'retailer';

    public static function getTypesAsString(): string
    {
        return implode(',', self::getTypes());
    }

    public static function getTypes(): array
    {
        return array_column(self::cases(), 'value');
    }
}
