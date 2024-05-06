<?php

namespace App\Service;

use App\Exception\Auth\InvalidTokenException;
use App\Exception\Auth\TokenExpiredException;
use Carbon\Carbon;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use function Hyperf\Config\config;

class TokenService implements TokenServiceInterface
{
    function generateToken(int $userId): string
    {
        return JWT::encode([
            'user_id' => $userId,
            'exp' => Carbon::now()->addSeconds(config('token_expiration_time'))
        ], config('jwt_secret_key'),
            'HS256'
        );
    }

    function getUserId(string $token): int
    {
        try {
            $decoded = JWT::decode($token, new Key(config('jwt_secret_key'), 'HS256'));

            if (empty($decoded->user_id)) {
                throw new InvalidTokenException($token);
            }

            return $decoded->user_id;
        } catch (ExpiredException) {
            throw new TokenExpiredException();
        }
    }
}
