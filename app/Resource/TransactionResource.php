<?php

namespace App\Resource;

use Carbon\Carbon;
use Hyperf\Resource\Json\JsonResource;
use function Hyperf\Config\config;

class TransactionResource extends JsonResource
{
    public function toArray(): array
    {
        return [
            'id' => $this['id'],
            'payerId' => $this['payer_id'],
            'payeeId' => $this['payee_id'],
            'value' => $this['value'],
            'createdAt' => $this['created_at'],
        ];
    }
}
