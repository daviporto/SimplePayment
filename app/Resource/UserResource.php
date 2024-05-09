<?php

namespace App\Resource;

use Carbon\Carbon;
use Hyperf\Resource\Json\JsonResource;
use function Hyperf\Config\config;

class UserResource extends JsonResource
{
    public function toArray(): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'type' => $this['type'],
        ];
    }
}
