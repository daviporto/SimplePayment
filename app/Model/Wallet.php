<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model as BaseModel;


/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $type
 * @property string $cpf
 * */
class Wallet extends BaseModel
{
    protected ?string $table = 'wallets';

    protected array $fillable = [
        'owner_id',
        'balance',
        'status'
    ];
}
