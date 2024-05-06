<?php

namespace App\Resource;

use Carbon\Carbon;
use Hyperf\Resource\Json\JsonResource;
use function Hyperf\Config\config;

class LoginUserResource extends JsonResource
{
    public function toArray(): array
    {
      return [
          'token' => $this['token'],
          'expires_at' => Carbon::now()->addSeconds(config('token_expiration_time'))->toDateTimeString(),
          'expires_in' => config('token_expiration_time'),
        ];
    }
}
